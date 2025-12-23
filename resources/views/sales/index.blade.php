@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Penjualan</h4>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Tambah Penjualan</a>
    </div>

    <table id="salesTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->sale_code }}</td>
                <td>{{ $sale->sale_date }}</td>
                <td>{{ $sale->status }}</td>
                <td>Rp {{ number_format($sale->total_amount) }}</td>
                <td>
                    <a href="{{ route('sales.show',$sale->id) }}" class="btn btn-sm btn-info">Detail</a>

                    @if($sale->status !== 'SUDAH_DIBAYAR')
                    <a href="{{ route('sales.edit',$sale->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('sales.destroy',$sale->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                    @endif
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
        $('#salesTable').DataTable();
    });
</script>
@endsection