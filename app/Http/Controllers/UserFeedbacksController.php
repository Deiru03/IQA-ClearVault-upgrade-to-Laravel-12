<?php

namespace App\Http\Controllers;

use App\Models\UsersFeedbackSystem as Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFeedbacksController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('user')->get();
        return view('components.Feedbacks.UserFeedbackForm', compact('feedbacks'));
    }

    public function create()
    {
        return view('components.Feedbacks.UserFeedbackForm');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'c1_1' => 'nullable|integer|min:1|max:5',
                'c1_2' => 'nullable|integer|min:1|max:5',
                'c1_3' => 'nullable|integer|min:1|max:5',
                'c1_4' => 'nullable|integer|min:1|max:5',
                'c1_5' => 'nullable|integer|min:1|max:5',
                'c2_1' => 'nullable|integer|min:1|max:5',
                'c2_2' => 'nullable|integer|min:1|max:5',
                'c2_3' => 'nullable|integer|min:1|max:5',
                'c2_4' => 'nullable|integer|min:1|max:5',
                'c2_5' => 'nullable|integer|min:1|max:5',
                'c3_1' => 'nullable|integer|min:1|max:5',
                'c3_2' => 'nullable|integer|min:1|max:5',
                'c3_3' => 'nullable|integer|min:1|max:5',
                'c3_4' => 'nullable|integer|min:1|max:5',
                'c3_5' => 'nullable|integer|min:1|max:5',
                'comment' => 'nullable|string|max:255',
            ]);

            Feedback::create([
                'user_id' => Auth::id(),
                'c1_1' => $request->c1_1,
                'c1_2' => $request->c1_2,
                'c1_3' => $request->c1_3,
                'c1_4' => $request->c1_4,
                'c1_5' => $request->c1_5,
                'c2_1' => $request->c2_1,
                'c2_2' => $request->c2_2,
                'c2_3' => $request->c2_3,
                'c2_4' => $request->c2_4,
                'c2_5' => $request->c2_5,
                'c3_1' => $request->c3_1,
                'c3_2' => $request->c3_2,
                'c3_3' => $request->c3_3,
                'c3_4' => $request->c3_4,
                'c3_5' => $request->c3_5,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Feedback submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error submitting feedback: ' . $e->getMessage());
        }
    }
}