<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->toDateString();
        $end   = $request->end_date   ?? now()->endOfMonth()->toDateString();

        // ===== WIDGET =====
        $totalTransaksi = Sale::whereBetween('sale_date', [$start, $end])->count();

        $totalPenjualan = Sale::whereBetween('sale_date', [$start, $end])
            ->sum('total_amount');

        $totalQty = SaleItem::whereHas('sale', function ($q) use ($start, $end) {
            $q->whereBetween('sale_date', [$start, $end]);
        })->sum('qty');

        // ===== CHART 1: Rupiah per Bulan =====
        $salesPerMonth = Sale::select(
            DB::raw('MONTH(sale_date) as month'),
            DB::raw('SUM(total_amount) as total')
        )
            ->whereBetween('sale_date', [$start, $end])
            ->groupBy(DB::raw('MONTH(sale_date)'))
            ->orderBy('month')
            ->get();

        // ===== CHART 2: Qty per Item =====
        $qtyPerItem = SaleItem::select(
            'item_id',
            DB::raw('SUM(qty) as total_qty')
        )
            ->with('item')
            ->groupBy('item_id')
            ->get();

        $salesMonthLabels = $salesPerMonth->pluck('month');
        $salesMonthTotals = $salesPerMonth->pluck('total');

        $qtyItemLabels = $qtyPerItem->pluck('item.name');
        $qtyItemTotals = $qtyPerItem->pluck('total_qty');

        return view('dashboard.index', compact(
            'totalTransaksi',
            'totalPenjualan',
            'totalQty',
            'salesMonthLabels',
            'salesMonthTotals',
            'qtyItemLabels',
            'qtyItemTotals',
            'start',
            'end'
        ));
    }
}
