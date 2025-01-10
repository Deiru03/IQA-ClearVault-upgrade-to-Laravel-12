<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\UploadedClearance;
use App\Models\SubmittedReport;
use App\Models\Program;
use App\Models\Campus;
use App\Models\Department;
use App\Models\SubProgram;

class OfficeController extends Controller
{
    public function dashboard(): View
    {
        return view("office.dashboard");
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
