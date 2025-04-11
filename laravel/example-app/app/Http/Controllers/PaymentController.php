<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('client')->get();
        return response()->json($payments);
    }

    public function create()
    {
        $clients = Client::all();
        return view('payments.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date_format:H:i',
        ]);

        $payment = Payment::create([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('payments.index');
    }

    public function show($id)
    {
        $payment = Payment::with('client')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $clients = Client::all();
        return view('payments.edit', compact('payment', 'clients'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date_format:H:i',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update([
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
        ]);

        return redirect()->route('payments.index');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index');
    }
}
