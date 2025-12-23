@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Pembayaran</h4>

    <form action="{{ route('payments.update',$payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kode Penjualan</label>
            <input class="form-control" value="{{ $payment->sale->sale_code }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nominal</label>
            <input type="number" name="amount" class="form-control"
                value="{{ old('amount',$payment->amount) }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection