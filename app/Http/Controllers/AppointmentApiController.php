<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Exception;
use App\Rules\AppointmentTimeRule;

class AppointmentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $appointments = Appointment::all();
            return response()->json($appointments);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appointments', 'message' => $e->getMessage()], 500);
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
            'date_time' => ['required|date', new AppointmentTimeRule],
        ]);

        try {
            $appointment = new Appointment();
            $appointment->doctor_id = $request->doctor_id;
            $appointment->patient_name = $request->patient_name;
            $appointment->date_time = $request->date_time;
            $appointment->save();

            return response()->json(['message' => 'Appointment created'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create appointment', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            return response()->json($appointment);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve appointment', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validation
        $request->validate([
            'doctor_id' => 'integer',
            'patient_name' => 'string|min:3',
            'patient_email' => 'email',
            'date_time' => ['date', new AppointmentTimeRule],
        ]);

        try {
            $appointment = Appointment::findOrFail($id);
            if ($request->has('doctor_id')) {
                $appointment->doctor_id = $request->doctor_id;
            }
            if ($request->has('patient_name')) {
                $appointment->patient_name = $request->patient_name;
            }
            if ($request->has('patient_email')) {
                $appointment->patient_email = $request->patient_email;
            }
            if ($request->has('date_time')) {
                $appointment->date_time = $request->date_time;
            }
            if ($request->has('status')) {
                $appointment->status = $request->status;
                // Delte patient name and email if status is available
                if ($request->status === 'available') {
                    $appointment->patient_name = null;
                    $appointment->patient_email = null;
                }
            }
    
            $appointment->save();

            return response()->json(['message' => 'Appointment updated']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update appointment', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return response()->json(['message' => 'Appointment deleted'], 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete appointment', 'message' => $e->getMessage()], 500);
        }
    }
}