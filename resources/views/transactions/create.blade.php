@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')

    <div class="card">
        <div class="card-body">

            <h4>Transaksi Pembayaran</h4>

            <p><b>Tamu :</b> {{ $registration->guest->full_name }}</p>
            <p><b>Kamar :</b> {{ $registration->room->room_number }}</p>

            <form method="POST" action="{{ route('transactions.store') }}">
                @csrf

                <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                <div class="mb-3">
                    <label>Total Bayar</label>
                    <input type="number" name="amount" class="form-control" value="{{ $registration->total_price }}">
                </div>

                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="payment_method" class="form-control">
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="card">Card</option>
                    </select>
                </div>

                <button class="btn btn-success">
                    Simpan Transaksi
                </button>

            </form>

        </div>
    </div>

@endsection
