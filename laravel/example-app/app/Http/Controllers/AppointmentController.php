<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Trainer;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['client', 'trainer', 'program'])->get();
        return response()->json($appointments);
    }

    public function create()
    {
        $clients = Client::all();
        $trainers = Trainer::all();
        $programs = TrainingProgram::all();
        return view('appointments.create', compact('clients', 'trainers', 'programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'trainer_id' => 'required|exists:trainers,id',
            'program_id' => 'required|exists:training_programs,id',
        ]);

        Appointment::create([
            'client_id' => $request->client_id,
            'trainer_id' => $request->trainer_id,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('appointments.index');
    }

    public function show($id)
    {
        $appointment = Appointment::with(['client', 'trainer', 'program'])->findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $clients = Client::all();
        $trainers = Trainer::all();
        $programs = TrainingProgram::all();
        return view('appointments.edit', compact('appointment', 'clients', 'trainers', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'trainer_id' => 'required|exists:trainers,id',
            'program_id' => 'required|exists:training_programs,id',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'client_id' => $request->client_id,
            'trainer_id' => $request->trainer_id,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('appointments.index');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('appointments.index');
    }
}
