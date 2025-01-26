<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;


class OthersController extends Controller
{
    public function feedbackIndex(): View
    {
        return view('others.views.userFeedback-index');
    }
}
