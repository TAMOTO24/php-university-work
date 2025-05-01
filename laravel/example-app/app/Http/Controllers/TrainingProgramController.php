<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainingProgram::query();
    
        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }
    
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
    
        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->input('description') . '%');
        }
    
        if ($request->has('time')) {
            $query->where('time', $request->input('time'));
        }
    
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $trainingPrograms = $query->paginate($itemsPerPage);
    
        return view('training-programs.index', compact('trainingPrograms'));
    }

    public function create()
    {
        return view('training_programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
        ]);

        TrainingProgram::create([
            'name' => $request->name,
            'description' => $request->description,
            'time' => $request->time,
        ]);

        return redirect()->route('training_programs.index');
    }

    public function show($id)
    {
        $trainingProgram = TrainingProgram::findOrFail($id);
        return view('training_programs.show', compact('trainingProgram'));
    }

    public function edit($id)
    {
        $trainingProgram = TrainingProgram::findOrFail($id);
        return view('training_programs.edit', compact('trainingProgram'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
        ]);

        $trainingProgram = TrainingProgram::findOrFail($id);
        $trainingProgram->update([
            'name' => $request->name,
            'description' => $request->description,
            'time' => $request->time,
        ]);

        return redirect()->route('training_programs.index');
    }

    public function destroy($id)
    {
        $trainingProgram = TrainingProgram::findOrFail($id);
        $trainingProgram->delete();
        return redirect()->route('training_programs.index');
    }
}
