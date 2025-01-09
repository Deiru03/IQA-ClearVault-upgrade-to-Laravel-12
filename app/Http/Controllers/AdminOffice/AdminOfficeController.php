<?php

namespace App\Http\Controllers\AdminOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UploadedClearance;
use App\Models\UserClearance;
use App\Models\SubmittedReport;
use App\Models\ClearanceFeedback;
use Illuminate\Support\Facades\Log;
use App\Models\Clearance;
use App\Models\SharedClearance;
use App\Models\Program;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminOfficeController extends Controller
{
    public function dashboard(): View
    {
        return view("office.dashboard");
    }
}
