<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $query = Trainer::query();
    
        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }
    
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }
    
        if ($request->has('last_name')) {
            $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
        }
    
        if ($request->has('specialization')) {
            $query->where('specialization', 'like', '%' . $request->input('specialization') . '%');
        }
    
        $itemsPerPage = $request->input('itemsPerPage', 10);
        $trainers = $query->paginate($itemsPerPage);
    
        return view('trainers.index', compact('trainers'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
        ]);

        Trainer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('trainers.index');
    }

    public function show($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('trainers.show', compact('trainer'));
    }

    public function edit($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
        ]);

        $trainer = Trainer::findOrFail($id);
        $trainer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'specialization' => $request->specialization,
        ]);

        return redirect()->route('trainers.index');
    }

    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();
        return redirect()->route('trainers.index');
    }
}
