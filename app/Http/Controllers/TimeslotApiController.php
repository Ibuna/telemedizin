<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use Exception;

class TimeslotApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $timeSlots = TimeSlot::all();
            return response()->json($timeSlots);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve timeslots', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'doctor_id' => 'required|integer',
            'start_time' => 'required|date_format:H:i',
        ]);

        try {
            $timeslot = new TimeSlot();
            $timeslot->doctor_id = $request->doctor_id;
            $timeslot->start_time = $request->start_time;
            $timeslot->save();

            return response()->json(['message' => 'Timeslot created'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create timeslot', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($id);
            return response()->json($timeSlot);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve timeslot', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'doctor_id' => 'required|integer',
            'start_time' => 'required|date_format:H:i',
        ]);

        try {
            $timeSlot = TimeSlot::findOrFail($id);
            $timeSlot->doctor_id = $request->doctor_id;
            $timeSlot->start_time = $request->start_time;
            $timeSlot->save();

            return response()->json(['message' => 'Timeslot updated']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update timeslot', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($id);
            $timeSlot->delete();

            return response()->json(['message' => 'Timeslot deleted'], 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete timeslot', 'message' => $e->getMessage()], 500);
        }
    }
}