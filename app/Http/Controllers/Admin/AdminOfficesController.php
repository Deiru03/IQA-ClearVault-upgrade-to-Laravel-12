<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Office;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "campus_id" => "required|integer",
            ]);

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('office_pictures', 'public');
                $validatedRequest['profile_picture'] = '/storage/' . $path;
            } else {
                $validatedRequest['profile_picture'] = null;
            }

            $officeStored = Office::create($validatedRequest);

            return redirect()->route("admin.views.offices-index")->with("success", "Office created successfully");
    
            // return redirect()->route("admin.views.offices-index")->with("success", "Office created successfully");
        } catch (\Exception $e) {
            Log::error('Office creation error: ' . $e->getMessage());
            return redirect()->route("admin.views.offices-index")->with("error", "Error creating office: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $office = Office::findOrFail($id);
            $campus = DB::table('campuses')
                ->select('name')
                ->where('id', $office->campus_id)
                ->first();
            $office->campus_name = $campus ? $campus->name : 'Unknown Campus';

            $office->staff_count = DB::table('users')
                ->where('office_id', $office->id)
                ->count();

            return response()->json($office);
        } catch (\Exception $e) {
            Log::error('Error fetching office details: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching office details'], 500);
        }
    }

    public function officeCampusName($id)
    {
        try {
            $campus = DB::table('campuses')->select('name')->where('id', $id)->first();
            if (!$campus) {
                return response()->json(['name' => 'Unknown Campus'], 404);
            }
            return response()->json(['name' => $campus->name]);
        } catch (\Exception $e) {
            Log::error('Error fetching campus name: ' . $e->getMessage());
            return response()->json(['name' => 'Unknown Campus'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editOffice(string $id)
    {
        try {
            $office = Office::findOrFail($id);
            return response()->json($office);
        } catch (\Exception $e) {
            Log::error('Error fetching office data: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching office data'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOffice(Request $request, string $id)
    {
        try {
            $validatedRequest = $request->validate([
                "name" => "required|string",
                "description" => "nullable|string",
                "profile_picture" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
                "campus_id" => "required|integer",
            ]);

            $office = Office::findOrFail($id);

            if ($request->hasFile('profile_picture')) {
                // Delete the old profile picture if it exists
                if ($office->profile_picture) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $office->profile_picture));
                }

                $path = $request->file('profile_picture')->store('office_pictures', 'public');
                $validatedRequest['profile_picture'] = '/storage/' . $path;
            }

            $office->update($validatedRequest);

            return redirect()->route("admin.views.offices-index")->with("success", "Office updated successfully");
        } catch (\Exception $e) {
            Log::error('Office update error: ' . $e->getMessage());
            return redirect()->route("admin.views.offices-index")->with("error", "Error updating office: " . $e->getMessage());
        }
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
