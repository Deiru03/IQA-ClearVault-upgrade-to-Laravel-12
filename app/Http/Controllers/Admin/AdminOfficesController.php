<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Office;

class AdminOfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexOffice(): View
    {
        $Offices = Office::all();
        return view("admin.views.offices.office-index", compact("Offices"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeOffice(Request $request)
    {
        try {
            $validatedRequest = $request->validate([
                "name" => "required|string",
                "description" => "nullable|string",
                // "department_id" => "nullable|integer",
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                "campus_id" => "required|integer",
            ]);

            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = $request->file('profile_picture')->store('office_pictures', 'public');
            }
    
    
            // if (empty($validatedRequest['profile_picture'])) {
            //     $validatedRequest['profile_picture'] = null;
            // }
            $validatedRequest['profile_picture'] = null;
    
            $officeStored = Office::create($validatedRequest);
    
            return redirect()->route("admin.views.offices-index", $officeStored)->with("success", "Office created successfully and Saved to the database");
    
            // return redirect()->route("admin.views.offices-index")->with("success", "Office created successfully");
        } catch (\Exception $e) {
            return redirect()->route("admin.views.offices-index")->with("error", "Error creating office");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyOffice(Office $officeId)
    {
        $officeId->delete();
        return redirect()->route("admin.views.offices-index" , $officeId)->with("success","Office deleted successfully");
    }
}
