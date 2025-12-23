<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $items = Item::all();
        return view('sales.create', compact('items'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $sale = Sale::create([
                'sale_code' => 'SALE-' . date('Ymd') . '-' . rand(1000, 9999),
                'sale_date' => now(),
                'status' => 'BELUM_DIBAYAR',
                'total_amount' => 0
            ]);

            $total = 0;

            foreach ($request->items as $row) {
                $subtotal = $row['qty'] * $row['price'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $row['item_id'],
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'total_price' => $subtotal
                ]);

                $total += $subtotal;
            }

            $sale->update(['total_amount' => $total]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Penjualan berhasil ditambahkan');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.item', 'payments');
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        if ($sale->status === 'SUDAH_DIBAYAR') {
            abort(403, 'Penjualan sudah dibayar');
        }

        $items = Item::all();
        $sale->load('items');
        return view('sales.edit', compact('sale', 'items'));
    }

    public function update(Request $request, Sale $sale)
    {
        if ($sale->status === 'SUDAH_DIBAYAR') {
            abort(403);
        }

        DB::transaction(function () use ($request, $sale) {

            $sale->items()->delete();
            $total = 0;

            foreach ($request->items as $row) {
                $subtotal = $row['qty'] * $row['price'];

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'item_id' => $row['item_id'],
                    'qty' => $row['qty'],
                    'price' => $row['price'],
                    'total_price' => $subtotal
                ]);

                $total += $subtotal;
            }

            $sale->update(['total_amount' => $total]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Penjualan berhasil diupdate');
    }

    public function destroy(Sale $sale)
    {
        if ($sale->status === 'SUDAH_DIBAYAR') {
            abort(403);
        }

        $sale->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Penjualan berhasil dihapus');
    }
}
