<?php

namespace App\Http\Controllers\ProgramHeadDean;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserClearance;
use App\Models\ProgramHeadDean;
use App\Models\SharedClearance;
use App\Models\Clearance;
use App\Models\SubmittedReport;


class PHDController extends Controller
{
    public function clearancePhD(): View
    {
                // Fetch the user clearance data
                $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', Auth::id())->first();

                $userInfo = Auth::user();
        
                return view('admin.views.phdean-views.phd-clearance', compact('userClearance', 'userInfo'));
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
            ->where('is_active', true)
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
            ->where('is_active', true)
            ->get();

        return view('admin.views.phdean-views.clearance-index', compact('filteredClearances', 'userClearances', 'recommendations', 'activeClearances'));
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
        UserClearance::where('user_id', $user->id)
            ->update(['is_active' => false]);

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

}
