<?php

namespace App\Http\Controllers\Office;

use App\Models\Campus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\SubmittedReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\UserClearance;
use App\Models\UploadedClearance;
use App\Models\SharedClearance;
use App\Models\Clearance;

class GenerateReports extends Controller
{
    public function generateClearanceReportOffice()
    {
        $user = Auth::user();

        $image = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        // $image = asset('images/OMSCLogo.png'); //not working
        // Fetch program name using the same logic we used before
        $user->program_name = Program::find($user->program_id)->name ?? 'N/A';

        $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', $user->id)->first();

        $pdf = Pdf::loadView('office.views.generate-reports.clearance-slip', compact('user', 'userClearance', 'image'));

        SubmittedReport::create([
            'admin_id' => null,
            'user_id' => Auth::id(),
            'title' => 'Generated Clearance Completion Slip',
            'transaction_type' => 'Slip Generated',
            'status' => 'Completed',
        ]);

        return $pdf->download('clearance-report.pdf');
    }

    public function generateChecklistOffice($id)
    {
        // Debugging: Log the ID being used
        Log::info('Generating checklist for clearance ID: ' . $id);

        $clearance = Clearance::with('requirements')->find($id);
        $sharedClearance = SharedClearance::with('clearance')->find($id);

        // Debugging: Check if clearance is found
        if (!$sharedClearance || !$sharedClearance->clearance) {
            return redirect()->back()->with('error', 'Clearance not found.');
        }
        $clearance = $sharedClearance->clearance;
        $user = Auth::user();

        $omscLogo = base64_encode(file_get_contents(public_path('/images/OMSCLogo.png'))); //working
        $iqaLogo = base64_encode(file_get_contents(public_path('/images/IQALogo.jpg'))); //working

        // Fetch requirements and their statuses
        $requirements = $clearance->requirements->map(function ($requirement) use ($user, $clearance) {
            $uploadedFiles = UploadedClearance::where('requirement_id', $requirement->id)
                ->where('user_id', $user->id)
                ->where('shared_clearance_id', $clearance->id)
                ->where('is_archived', false)
                ->get();

            $feedback = $requirement->feedback->where('user_id', $user->id)->first();

            $status = 'Not Complied';
            if ($uploadedFiles->isNotEmpty()) {
                $status = 'Complied';
            } elseif ($feedback && $feedback->signature_status == 'Resubmit') {
                $status = 'Resubmit';
            } elseif ($feedback && $feedback->signature_status == 'Complied') {
                $status = 'Complied';
            } elseif ($feedback && $feedback->signature_status == 'Checking') {
                $status = 'Not Complied';
            } elseif ($feedback && $feedback->signature_status == 'Not Applicable') {
                $status = 'Not Applicable';
            }

            return [
                'requirement' => $requirement,
                'status' => $status,
            ];
        });

        $department = $user->department ? $user->department->name : 'N/A';
        $program = User::find($user->program);
        $lastClearanceUpdate = $user->last_clearance_update ? $user->last_clearance_update->format('F j, Y') : 'N/A';

        $pdf = PDF::loadView('office.views.generate-reports.generate-checklist', compact('clearance', 'omscLogo', 'iqaLogo', 'requirements', 'user', 'department', 'program', 'lastClearanceUpdate'))
            ->setPaper('legal', 'portrait');
        return $pdf->stream('clearance_' . $clearance->id . '_' . $clearance->document_name . '.pdf');
    }
}
