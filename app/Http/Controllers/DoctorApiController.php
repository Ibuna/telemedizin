<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Exception;

class DoctorApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $doctors = Doctor::with('specialization')->get();
            return response()->json($doctors);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve doctors', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization_id' => 'required|integer',
        ]);

        try {
            $doctor = new Doctor();
            $doctor->name = $request->name;
            $doctor->specialization_id = $request->specialization_id;
            $doctor->save();

            return response()->json(['message' => 'Doctor created']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create doctor', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $doctor = Doctor::with([
                'timeslots' => function ($query) {
                    $query->orderBy('start_time');
                },
                'specialization',
                'appointments' => function ($query) {
                    $query->orderBy('date_time');
                },
            ])->findOrFail($id);
            return response()->json($doctor);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve doctor', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization_id' => 'required|integer',
        ]);

        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->name = $request->name;
            $doctor->specialization_id = $request->specialization_id;
            $doctor->save();

            return response()->json(['message' => 'Doctor updated']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update doctor', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            $doctor->delete();

            return response()->json(['message' => 'Doctor deleted']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete doctor', 'message' => $e->getMessage()], 500);
        }
    }
}