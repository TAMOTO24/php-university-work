<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Trainer;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['client', 'trainer', 'program']);

        # prototype /appointments?client_id=3&date=2024-04-01&itemsPerPage=5

        if ($request->has('date')) {
            $query->where('date', $request->input('date'));
        }

        if ($request->has('time')) {
            $query->where('time', $request->input('time'));
        }

        if ($request->has('client_id')) {
            $query->where('client_id', $request->input('client_id'));
        }

        if ($request->has('trainer_id')) {
            $query->where('trainer_id', $request->input('trainer_id'));
        }

        if ($request->has('program_id')) {
            $query->where('program_id', $request->input('program_id'));
        }

        $itemsPerPage = $request->input('itemsPerPage', 10);

        $appointments = $query->paginate($itemsPerPage);

        return view('appointments.index', compact('appointments'));
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
            'appointment_date' => 'required|date',
        ]);

        Appointment::create([
            'client_id' => $request->client_id,
            'trainer_id' => $request->trainer_id,
            'program_id' => $request->program_id,
            'appointment_date' => $request->appointment_date,
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

        $appointment_date = \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i');

        return view('appointments.edit', compact('appointment', 'clients', 'trainers', 'programs', 'appointment_date'));
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
