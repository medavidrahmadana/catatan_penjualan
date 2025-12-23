<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('sale')
            ->latest()
            ->get();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        // hanya penjualan yg belum lunas
        $sales = Sale::whereIn('status', [
            'BELUM_DIBAYAR',
            'BELUM_DIBAYAR_SEPENUHNYA'
        ])->get();

        return view('payments.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $sale = Sale::findOrFail($request->sale_id);

        DB::transaction(function () use ($request, $sale) {

            $totalPaid = $sale->payments()->sum('amount');

            // VALIDASI: tidak boleh bayar lebih
            if ($totalPaid + $request->amount > $sale->total_amount) {
                abort(422, 'Pembayaran melebihi total penjualan');
            }

            Payment::create([
                'payment_code' => 'PAY-' . date('Ymd') . '-' . rand(1000, 9999),
                'sale_id' => $sale->id,
                'payment_date' => now(),
                'amount' => $request->amount
            ]);

            $newTotal = $sale->payments()->sum('amount');

            if ($newTotal == $sale->total_amount) {
                $sale->update(['status' => 'SUDAH_DIBAYAR']);
            } else {
                $sale->update(['status' => 'BELUM_DIBAYAR_SEPENUHNYA']);
            }
        });

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil');
    }

    public function show(Payment $payment)
    {
        $payment->load('sale');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        DB::transaction(function () use ($request, $payment) {

            $sale = $payment->sale;

            // total selain payment ini
            $otherPayments = $sale->payments()
                ->where('id', '!=', $payment->id)
                ->sum('amount');

            if ($otherPayments + $request->amount > $sale->total_amount) {
                abort(422, 'Pembayaran melebihi total penjualan');
            }

            $payment->update([
                'amount' => $request->amount
            ]);

            $newTotal = $sale->payments()->sum('amount');

            if ($newTotal == $sale->total_amount) {
                $sale->update(['status' => 'SUDAH_DIBAYAR']);
            } else {
                $sale->update(['status' => 'BELUM_DIBAYAR_SEPENUHNYA']);
            }
        });

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil diupdate');
    }

    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $sale = $payment->sale;
            $payment->delete();

            $totalPaid = $sale->payments()->sum('amount');

            if ($totalPaid == 0) {
                $sale->update(['status' => 'BELUM_DIBAYAR']);
            } elseif ($totalPaid < $sale->total_amount) {
                $sale->update(['status' => 'BELUM_DIBAYAR_SEPENUHNYA']);
            }
        });

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dihapus');
    }
}
