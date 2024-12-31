<?php

namespace App\Http\Controllers\ProgramHeadDean;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\UserClearance;
use App\Models\ProgramHeadDean;
use App\Models\SharedClearance;
use App\Models\Clearance;
use App\Models\SubmittedReport;
use App\Models\User;
use App\Models\UploadedClearance;
use App\Models\ClearanceRequirement;
use App\Models\UserNotification;
use App\Models\ClearanceFeedback;


class PHDClearanceController extends Controller
{

    // Dean and Program-Head Clearance
    // File Path: resources/views/admin/views/phdean-views/phd-clearance.blade.php
    // ******************** Main Localtion of files here is in the faculty folder ********************
    // Location: resources/views/admin/views/phdean-views
    public function clearancePhD(): View
    {
        // Fetch the user clearance data for Program-Head or Dean
        $userClearance = UserClearance::where('user_id', Auth::id())
            ->whereHas('sharedClearance.clearance', function($query) {
                $query->whereIn('type', ['Program-Head', 'Dean']);
            })
            ->with('sharedClearance.clearance')
            ->first();

        $userInfo = Auth::user();

        // Fetch the user clearance data for FACULTY only
        $userClearanceFaculty = UserClearance::where('user_id', Auth::id())
            ->whereHas('sharedClearance.clearance', function($query) {
                $query->whereNot('type', ['Program-Head', 'Dean']);
            })
            ->with('sharedClearance.clearance')
            ->first();

        return view('admin.views.phdean-views.phd-clearance', compact('userClearance','userClearanceFaculty' ,'userInfo'));
    }

    public function indexPhD(): View
    {
        $user = Auth::user();
        $userUnits = $user->units;
        $userType = $user->user_type;

        // Get all shared clearances with their associated clearance data
        $sharedClearances = SharedClearance::with('clearance')->get();

        // Filter shared clearances based on user_type and units
        $filteredClearances = $sharedClearances->filter(function ($sharedClearance) use ($userUnits, $userType) {
            $clearanceUnits = $sharedClearance->clearance->units;
            $clearanceType = $sharedClearance->clearance->type;

            // For Dean and Program-Head based on user_type
            if ($userType === 'Dean' || $userType === 'Program-Head') {
                // If user has no units, fetch all clearances of matching user_type
                if ($userType === 'Dean') {
                    if (is_null($userUnits)) {
                        return $clearanceType === 'Dean';
                    }
                    // If clearance has units and user has units, check if they match
                    if (!is_null($clearanceUnits)) {
                        return $clearanceType === 'Dean' && $clearanceUnits == $userUnits;
                    }
                    // If clearance has no units but user has units, still fetch it
                    return $clearanceType === 'Dean';
                } 
                else if ($userType === 'Program-Head') {
                    if (is_null($userUnits)) {
                        return $clearanceType === 'Program-Head';
                    }
                    // If clearance has units and user has units, check if they match
                    if (!is_null($clearanceUnits)) {
                        return $clearanceType === 'Program-Head' && $clearanceUnits == $userUnits;
                    }
                    // If clearance has no units but user has units, still fetch it
                    return $clearanceType === 'Program-Head';
                }
            }
            return false;
            
        });

        // Get user_clearances to map shared_clearance_id to user_clearance_id
        // Only get active clearances
        $userClearances = UserClearance::where('user_id', $user->id)
            // ->where('is_active', true)
            ->whereIn('shared_clearance_id', $filteredClearances->pluck('id'))
            ->pluck('id', 'shared_clearance_id')
            ->toArray();

        // Determine recommendations based on user's position and units
        $recommendations = $filteredClearances->filter(function ($sharedClearance) use ($user) {
            // Filter for Dean position
            if ($user->position === 'Dean') {
                return $sharedClearance->clearance->type === 'Dean';
            }
            
            // Filter for Program-Head position
            if ($user->position === 'Program-Head') {
                return $sharedClearance->clearance->type === 'Program-Head';
            }
            
            // Filter for other positions based on type and units
            return $sharedClearance->clearance->type === $user->position &&
                   $sharedClearance->clearance->units == $user->units;
        });

        // Get active clearances
        $activeClearances = UserClearance::where('user_id', $user->id)
            // ->where('is_active', true)
            ->get();

        return view('admin.views.phdean-views.phd-clearance-index', compact('filteredClearances', 'userClearances', 'recommendations', 'activeClearances'));
    }

     /**
     * Handle the user getting a copy of a shared clearance.
     */
    public function getCopyPhD($id)
    {
        $user = Auth::user();
        $sharedClearance = SharedClearance::findOrFail($id);

        // Check if the user has already copied this clearance
        $existingCopy = UserClearance::where('shared_clearance_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingCopy) {
            return redirect()->route('phd.programHeadDean.indexPhD')->with('error', 'You have already copied this clearance.');
        }

        // Deactivate other clearances
        // UserClearance::where('user_id', $user->id)
        //     ->update(['is_active' => false]);

        // Create a new user clearance and set it as active
        UserClearance::create([
            'shared_clearance_id' => $id,
            'user_id' => $user->id,
            'is_active' => true,

        ]);

        SubmittedReport::create([
            'user_id' => Auth::id(),
            'title' => 'Copied a clearance for ' . $sharedClearance->clearance->name,
            'transaction_type' => 'Aquired Checklist',
            'status' => 'Completed',
        ]);
        return redirect()->route('phd.programHeadDean.indexPhD')->with('success', 'Clearance copied and set as active successfully.');
    }

    public function removeCopyPhD($id)
    {
        $user = Auth::user();

        try {
            // Find the user's clearance copy
            $userClearance = UserClearance::where('shared_clearance_id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Delete the user's clearance copy
            $userClearance->delete();

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'title' => 'Removed a clearance copy for ' . $userClearance->sharedClearance->clearance->name,
                'transaction_type' => 'Removed Checklist',
                'status' => 'Completed',
            ]);

            return redirect()->route('phd.programHeadDean.indexPhD')->with('success', 'Clearance copy removed successfully.');
        } catch (\Exception $e) {
            Log::error('Removing Clearance Copy Error: '.$e->getMessage());

            return redirect()->route('phd.programHeadDean.indexPhD')->with('error', 'Failed to remove clearance copy.');
        }
    }

    public function showPhD($id)
    {
        $user = Auth::user();
        $userInfo = $user;
        // Confirm that the user has copied this clearance
        $userClearance = UserClearance::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['sharedClearance.userClearances' => function ($query) {
                $query->where('is_active', true);
            }])
            ->firstOrFail();

        // Fetch already uploaded clearances by the user for this shared clearance
        $uploadedClearances = UploadedClearance::where('shared_clearance_id', $userClearance->shared_clearance_id)
            ->where('user_id', $user->id)
            ->where('is_archived', false)
            ->pluck('requirement_id')
            ->toArray();

        return view('admin.views.phdean-views.phd-clearance-show', compact('userClearance', 'uploadedClearances', 'userInfo'));
    }


    /**
     * Handle the file upload for a specific requirement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sharedClearanceId
     * @param  int  $requirementId
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhD(Request $request, $sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|mimes:pdf|max:200000', //,doc,docx,jpg,png',
            'title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->hasFile('files')) {
            try {
                $uploadedFiles = [];
                foreach ($request->file('files') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/faculty_clearances', $originalName, 'public');

                    $uploadedClearance = UploadedClearance::create([
                        'shared_clearance_id' => $sharedClearanceId,
                        'requirement_id' => $requirementId,
                        'user_id' => $user->id,
                        'file_path' => $path,
                    ]);

                    $uploadedFiles[] = $originalName;
                }

                $requirement = ClearanceRequirement::findOrFail($requirementId);
                $requirementName = $requirement->requirement;
                $fileCount = count($uploadedFiles);

                // Truncate requirement name if longer than 100 characters
                if (strlen($requirementName) > 100) {
                    $requirementName = substr($requirementName, 0, 100) . '...';
                }

                // Create single report for all uploaded files
                SubmittedReport::create([
                    'user_id' => Auth::id(),
                    'title' => "Uploaded {$fileCount} file(s) for requirement: {$requirementName}",
                    'transaction_type' => 'Uploaded',
                    'status' => 'Okay',
                ]);
                 // Create a notification for the user
                 UserNotification::create([
                    'user_id' => Auth::id(),
                    'admin_user_id' => null,
                    'notification_type' => 'File Uploaded',
                    'notification_message' => "Uploaded a {$fileCount} file(s) for requirement: {$requirementName}.",
                    'is_read' => false,
                ]);

                // Find the UserClearance record
                $userClearance = UserClearance::where('user_id', $user->id)
                    ->where('shared_clearance_id', $sharedClearanceId)
                    ->firstOrFail();

                // Update the 'updated_at' timestamp
                $userClearance->touch();

                // Create feedback for the requirement
                ClearanceFeedback::create([
                    'user_id' => $user->id,
                    'requirement_id' => $requirementId,
                    'signature_status' => 'Checking',
                    'is_archived' => false,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Files uploaded successfully for requirement id:' . $requirementId .' with ' . $fileCount . ' file(s).',
                ]);
            } catch (\Exception $e) {
                Log::error('File Upload Error: '.$e->getMessage());

                SubmittedReport::create([
                    'user_id' => Auth::id(),
                    'title' => 'Failed to upload files',
                    'transaction_type' => 'Upload Failed',
                    'status' => 'Failed',
                ]);


                session()->flash('error', 'Failed to upload files.');
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload files.',
                ], 500);
            }
        }

        session()->flash('error', 'No files uploaded.');
        return response()->json([
            'success' => false,
            'message' => 'No files uploaded.',
        ], 400);
    }


    public function deleteFilePhD($sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Retrieve all uploaded clearances for the specific requirement
            $uploadedClearances = UploadedClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();

            $deletedFiles = [];

            foreach ($uploadedClearances as $uploadedClearance) {
                // Check if the file exists before attempting to delete
                if (Storage::disk('public')->exists($uploadedClearance->file_path)) {
                    Storage::disk('public')->delete($uploadedClearance->file_path);
                }

                $deletedFiles[] = [
                    'file_name' => basename($uploadedClearance->file_path),
                    'deleted_at' => now(),
                ];

                // Delete the record from the database
                $uploadedClearance->delete();
            }

            $requirement = ClearanceRequirement::findOrFail($requirementId);
            $requirementName = $requirement->requirement;
            $fileCount = count($deletedFiles);

            // Truncate requirement name if longer than 100 characters
            if (strlen($requirementName) > 100) {
                $requirementName = substr($requirementName, 0, 100) . '...';
            }

            // Log the deletion in SubmittedReport
            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => "Deleted {$fileCount} file(s) for requirement: {$requirementName}",
                'transaction_type' => 'Removed File',
                'status' => 'Okay',
            ]);

            DB::commit();

            session()->flash('successDelete', 'All files related to this requirement have been deleted successfully and recorded.');

            return response()->json([
                'success' => true,
                'message' => 'All files related to this requirement have been deleted successfully and recorded.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File Deletion Error: '.$e->getMessage());

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'title' => 'Failed to delete files',
                'transaction_type' => 'Delete',
                'status' => 'Failed',
            ]);

            session()->flash('error', 'Failed to delete the files.');

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the files.',
            ], 500);
        }
    }

    public function deleteSingleFilePhD($sharedClearanceId, $requirementId, $fileId)
    {
        $user = Auth::user();

        try {
            // Retrieve the specific UploadedClearance record
            $uploadedClearance = UploadedClearance::where('id', $fileId)
                ->where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Delete the file from storage
            if (Storage::disk('public')->exists($uploadedClearance->file_path)) {
                Storage::disk('public')->delete($uploadedClearance->file_path);
            }

            // Delete the record from the database
            $uploadedClearance->delete();

            $requirement = ClearanceRequirement::findOrFail($requirementId);
            $requirementName = $requirement->requirement;

            // Truncate requirement name if longer than 100 characters
            if (strlen($requirementName) > 100) {
                $requirementName = substr($requirementName, 0, 100) . '...';
            }

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => "Deleted file for requirement: {$requirementName}",
                'transaction_type' => 'Delete',
                'status' => 'Okay',
            ]);

            session()->flash('successDelete', 'File deleted successfully.');

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Deleting Single File Error: '.$e->getMessage());

            SubmittedReport::create([
                'user_id' => Auth::id(),
                'admin_id' => null,
                'title' => 'Failed to delete file',
                'transaction_type' => 'Removed',
                'status' => 'Failed',
            ]);

            session()->flash('error', 'Failed to delete the file.');

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the file.',
            ], 500);
        }
    }


    // Single File View Get or Fetch
        /**
     * Retrieve all uploaded files for a specific requirement.
     *
     * @param  int  $sharedClearanceId
     * @param  int  $requirementId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUploadedFilesPhD($sharedClearanceId, $requirementId)
    {
        $user = Auth::user();

        try {
            $uploadedFiles = UploadedClearance::where('shared_clearance_id', $sharedClearanceId)
                ->where('requirement_id', $requirementId)
                ->where('user_id', $user->id)
                ->where('is_archived', false)
                ->get();

            $files = $uploadedFiles->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => basename($file->file_path),
                    'file_path' => $file->file_path,  // Changed from url to file_path
                ];
            });

            return response()->json([
                'success' => true,
                'files' => $files,
            ]);
        } catch (\Exception $e) {
            Log::error('Fetching Uploaded Files Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch uploaded files.',
            ], 500);
        }
    }
}
