@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Pembayaran</h4>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kode Pembayaran</th>
                <th>Kode Penjualan</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->payment_code }}</td>
                <td>{{ $payment->sale->sale_code }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                <td>{{ rupiah($payment->amount) }}</td>
                <td>
                    <a href="{{ route('payments.show',$payment->id) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('payments.edit',$payment->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('payments.destroy',$payment->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin hapus pembayaran?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#paymentTable').DataTable();
    });
</script>
@endsection