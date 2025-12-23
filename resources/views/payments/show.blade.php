@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Detail Pembayaran</h4>

    <table class="table table-bordered table-hover align-middle">
        <tr>
            <th>Kode Pembayaran</th>
            <td>{{ $payment->payment_code }}</td>
        </tr>
        <tr>
            <th>Kode Penjualan</th>
            <td>{{ $payment->sale->sale_code }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Nominal</th>
            <td>{{ rupiah($payment->amount) }}</td>
        </tr>
    </table>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection