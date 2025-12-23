@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Detail Penjualan</h4>

    <div class="mb-3">
        <strong>Kode Penjualan:</strong> {{ $sale->sale_code }} <br>
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
        <br>
        <strong>Status:</strong>
        <span class="badge bg-{{ $sale->status == 'SUDAH_DIBAYAR' ? 'success' : 'warning' }}">
            @if($sale->status == 'SUDAH_DIBAYAR')
            <span class="badge bg-success">SUDAH DIBAYAR</span>
            @elseif($sale->status == 'BELUM_DIBAYAR_SEPENUHNYA')
            <span class="badge bg-warning text-dark">BELUM DIBAYAR SEBAGIAN</span>
            @else
            <span class="badge bg-secondary">BELUM DIBAYAR</span>
            @endif

        </span>
    </div>

    <h5>Item Penjualan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th width="100">Qty</th>
                <th width="150">Harga</th>
                <th width="150">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $row)
            <tr>
                <td>{{ $row->item->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ rupiah($row->price) }}</td>
                <td>{{ rupiah($row->total_price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h5 class="mt-3">Total: {{ rupiah($sale->total_amount) }}
    </h5>

    <hr>

    <h5>Riwayat Pembayaran</h5>
    @if($sale->payments->count())
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Kode Pembayaran</th>
                <th>Tanggal</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->payments as $pay)
            <tr>
                <td>{{ $pay->payment_code }}</td>
                <td>{{ $pay->payment_date }}</td>
                <td>{{ rupiah($pay->amount) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p class="text-muted">Belum ada pembayaran.</p>
    @endif

    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection