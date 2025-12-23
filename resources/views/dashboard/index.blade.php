@extends('layouts.app')

@section('content')
<div class="container">

    <form method="GET" class="row mb-4">
        <div class="col">
            <input type="date" name="start_date" value="{{ $start }}" class="form-control">
        </div>
        <div class="col">
            <input type="date" name="end_date" value="{{ $end }}" class="form-control">
        </div>
        <div class="col">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="row text-center mb-4">
        <div class="col">
            <h5>Jumlah Transaksi</h5>
            <h3>{{ $totalTransaksi }}</h3>
        </div>
        <div class="col">
            <h5>Total Penjualan</h5>
            <h3>Rp {{ number_format($totalPenjualan) }}</h3>
        </div>
        <div class="col">
            <h5>Total Qty</h5>
            <h3>{{ $totalQty }}</h3>
        </div>
    </div>

    <canvas id="chartRupiah"></canvas>
    <br>
    <canvas id="chartQty"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const salesMonthLabels = @json($salesMonthLabels);
    const salesMonthTotals = @json($salesMonthTotals);

    const qtyItemLabels = @json($qtyItemLabels);
    const qtyItemTotals = @json($qtyItemTotals);

    new Chart(document.getElementById('chartRupiah'), {
        type: 'bar',
        data: {
            labels: salesMonthLabels,
            datasets: [{
                label: 'Penjualan per Bulan',
                data: salesMonthTotals
            }]
        }
    });

    new Chart(document.getElementById('chartQty'), {
        type: 'pie',
        data: {
            labels: qtyItemLabels,
            datasets: [{
                data: qtyItemTotals
            }]
        }
    });
</script>
@endsection