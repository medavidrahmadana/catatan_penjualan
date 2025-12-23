@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Penjualan</h4>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Tambah Penjualan</a>
    </div>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
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
                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}
                </td>
                <td>@if($sale->status == 'SUDAH_DIBAYAR')
                    <span class="badge bg-success">SUDAH DIBAYAR</span>
                    @elseif($sale->status == 'BELUM_DIBAYAR_SEPENUHNYA')
                    <span class="badge bg-warning text-dark">BELUM DIBAYAR SEBAGIAN</span>
                    @else
                    <span class="badge bg-secondary">BELUM DIBAYAR</span>
                    @endif
                </td>
                <td>{{ rupiah($sale->total_amount) }}</td>
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