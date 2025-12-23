@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Tambah Pembayaran</h4>

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Penjualan</label>
            <select name="sale_id" class="form-control" required>
                <option value="">-- pilih penjualan --</option>
                @foreach($sales as $sale)
                <option value="{{ $sale->id }}">
                    {{ $sale->sale_code }} - {{ rupiah($sale->total_amount) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Nominal Pembayaran</label>
            <input type="number" name="amount" class="form-control" required min="1">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection