<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'membership_type' => 'required|string|max:255',
        ]);

        Client::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'membership_type' => $request->membership_type,
        ]);

        return redirect()->route('clients.index');
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'membership_type' => 'required|string|max:255',
        ]);

        $client = Client::findOrFail($id);
        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'dob' => $request->dob,
            'membership_type' => $request->membership_type,
        ]);

        return redirect()->route('clients.index');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index');
    }
}
