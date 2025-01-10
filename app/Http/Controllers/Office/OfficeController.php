<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use App\Models\ClearanceFeedback;
use App\Models\SubmittedReport;
use App\Models\Program;
use App\Models\Campus;
use App\Models\Department;
use App\Models\SubProgram;

class OfficeController extends Controller
{
    public function home(): View
    {
        return view('office.home');
    }

    public function overview(): View
    {
        return view('office.overview');
    }   

    private function getUserStorageSize($userId)
    {
        $totalSize = 0;

        $uploadedClearances = UploadedClearance::where('user_id', $userId)->get();

        foreach ($uploadedClearances as $clearance) {
            $filePath = storage_path('app/public/' . $clearance->file_path);
            if (file_exists($filePath)) {
                $totalSize += filesize($filePath);
            }
        }

        return $totalSize;
    }

    public function dashboard(): View
    {
        $user = Auth::user();
        $showProfileModal = empty($user->program_id) || empty($user->department_id) || empty($user->position);

        // Fetch the user's current active clearance data
        $userClearance = UserClearance::with(['sharedClearance.clearance.requirements', 'uploadedClearances'])
            ->where('user_id', $user->id)
            ->where('is_active', true) // Ensure only active clearance is fetched
            ->first();

        $noActiveClearance = !$userClearance;

        $userFeedbackReturn = ClearanceFeedback::where('user_id', $user->id)
            ->where('signature_status', 'resubmit')
            ->count();

        $totalRequirements = 0;
        $uploadedRequirements = 0;
        $missingRequirements = 0;
        $returnedDocuments = 0;
        $completionRate = 0; // Initialize completion rate

        if ($userClearance) {
            $totalRequirements = $userClearance->sharedClearance->clearance->requirements->count();

            // Filter uploaded clearances to only include those for the current active clearance
            $currentUploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();

            $uploadedRequirements = $currentUploadedClearances->unique('requirement_id')->count();
            $missingRequirements = $totalRequirements - $uploadedRequirements;
            $returnedDocuments = ClearanceFeedback::whereIn('requirement_id', $currentUploadedClearances->pluck('requirement_id'))
                ->where('user_id', $user->id)
                ->where('signature_status', 'resubmit')
                ->count();

            // Calculate completion rate
            if ($totalRequirements > 0) {
                $completionRate = ($uploadedRequirements / $totalRequirements) * 100;
                $completionRate = number_format($completionRate, 2); // Format to two decimal places
            }
        }

        return view('office.dashboard', compact(
            'showProfileModal',
            'noActiveClearance',
            'totalRequirements',
            'uploadedRequirements',
            'missingRequirements',
            'returnedDocuments',
            'userFeedbackReturn',
            'completionRate' // Pass formatted completion rate to the view
        ));
    }

    public function MyFiles(): View 
    {
        $user = Auth::user();

        // Fetch all uploaded clearances for the authenticated user
        $uploadedFiles = UploadedClearance::where('user_id', $user->id)
            ->with('requirement')
            ->where('is_archived', false)
            ->select('id', 'shared_clearance_id', 'requirement_id', 'user_id', 'file_path', 'created_at', 'updated_at')
            ->get();

        return view('office.views.my-files', compact('uploadedFiles'));
    }

    public function archive(Request $request): View 
    {
        $user = Auth::user();
        $sortOrder = $request->get('sort', 'desc'); // Default to newest
        $search = $request->get('search', '');

        $archivedClearances = UploadedClearance::where('user_id', $user->id)
            ->where('is_archived', true)
            ->where('file_path', 'like', "%{$search}%") // Search by file path
            ->orderBy('academic_year', $sortOrder)
            ->orderBy('semester', $sortOrder)
            ->orderBy('updated_at', $sortOrder)
            ->get();

        return view('office.views.archive', compact('archivedClearances', 'sortOrder', 'search'));
    }

    public function historyReport(): View 
    {
        $reports = SubmittedReport::with('admin')
            ->where('user_id', Auth::id())
            ->get();

        return view('office.views.history-reports', compact('reports'));
    }

    public function profileEdit(): View
    {
        $user = Auth::user();
        $departments = Department::with('programs')->get();
        $programs = Program::all();
        $campuses = Campus::all();

        // Fetch the user's sub-programs
        $subProgram = SubProgram::where('user_id', $user->id)->first();

        $noActiveClearance = true;

        return view ('office.profile.edit', compact('user', 'departments', 'noActiveClearance', 'campuses', 'programs', 'subProgram'));
    }

}
