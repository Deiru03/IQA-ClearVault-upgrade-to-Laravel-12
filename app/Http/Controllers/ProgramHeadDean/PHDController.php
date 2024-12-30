<?php

namespace App\Http\Controllers\ProgramHeadDean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserClearance;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PHDController extends Controller
{
    public function indexPHD(): View
    {
                // Fetch the user clearance data
                $userClearance = UserClearance::with('sharedClearance.clearance')->where('user_id', Auth::id())->first();

                $userInfo = Auth::user();
        
                return view('admin.views.phdean-views.phd-clearance', compact('userClearance', 'userInfo'));
    }
}
