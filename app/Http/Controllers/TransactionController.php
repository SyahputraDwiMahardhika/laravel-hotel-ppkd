<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Registration;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create($registration)
    {
        $registration = Registration::with(['guest', 'room.roomType'])
            ->findOrFail($registration);

        return view('transactions.create', compact('registration'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        Transaction::create([
            'registration_id' => $request->registration_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'paid'
        ]);

        return redirect()->route('registrations.index')
            ->with('success', 'Transaksi berhasil disimpan');
    }
}
