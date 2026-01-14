<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Pembeli - form pembelian
    public function create(Property $property)
    {
        if (!$property->isAvailable()) {
            return redirect()->route('properties.show', $property)->with('error', 'Property tidak tersedia');
        }
        return view('orders.create', compact('property'));
    }

    // Pembeli - store order
    public function store(Request $request, Property $property)
    {
        $this->authorize('isBuyer');

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        if ($validated['quantity'] > $property->stock) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $total_price = $property->price * $validated['quantity'];
        $invoice_number = 'INV-' . strtoupper(Str::random(8)) . '-' . time();

        $order = Order::create([
            'invoice_number' => $invoice_number,
            'buyer_id' => auth()->id(),
            'seller_id' => $property->seller_id,
            'property_id' => $property->id,
            'quantity' => $validated['quantity'],
            'price' => $property->price,
            'total_price' => $total_price,
            'notes' => $validated['notes'] ?? null,
            'ordered_at' => now(),
            'status' => 'pending',
        ]);

        // Kurangi stock
        $property->decrement('stock', $validated['quantity']);

        return redirect()->route('buyer.orders.show', $order)->with('success', 'Pesanan berhasil dibuat!');
    }

    // Pembeli - lihat pesanan mereka
    public function buyerOrders()
    {
        $this->authorize('isBuyer');
        $orders = auth()->user()->orders()->with('property', 'seller')->latest()->paginate(10);
        return view('buyer.orders', compact('orders'));
    }

    // Penjual - lihat pesanan mereka
    public function sellerOrders()
    {
        $this->authorize('isSeller');
        $orders = auth()->user()->sellerOrders()->with('property', 'buyer')->latest()->paginate(10);
        return view('seller.orders', compact('orders'));
    }

    // Lihat detail order + cetak invoice
    public function show(Order $order)
    {
        // Pembeli melihat ordernya sendiri, atau penjual melihat order untuk propertinya
        if (auth()->user()->isBuyer()) {
            $this->authorize('isBuyer');
            if ($order->buyer_id != auth()->id()) {
                abort(403);
            }
        } else {
            $this->authorize('isSeller');
            if ($order->seller_id != auth()->id()) {
                abort(403);
            }
        }

        return view('orders.show', compact('order'));
    }

    // Penjual - konfirmasi order
    public function confirm(Order $order)
    {
        $this->authorize('isSeller');

        if ($order->seller_id != auth()->id()) {
            abort(403);
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    // Penjual - tandai sebagai selesai
    public function complete(Order $order)
    {
        $this->authorize('isSeller');

        if ($order->seller_id != auth()->id()) {
            abort(403);
        }

        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil diselesaikan!');
    }

    // Cancel order
    public function cancel(Order $order)
    {
        // Pembeli atau penjual bisa cancel
        if (auth()->user()->isBuyer() && $order->buyer_id != auth()->id()) {
            abort(403);
        }
        if (auth()->user()->isSeller() && $order->seller_id != auth()->id()) {
            abort(403);
        }

        if ($order->status != 'pending') {
            return back()->with('error', 'Hanya pesanan pending yang bisa dibatalkan');
        }

        // Kembalikan stock
        $order->property->increment('stock', $order->quantity);

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }

    // Pembeli - cetak invoice
    public function printInvoice(Order $order)
    {
        $this->authorize('isBuyer');

        if ($order->buyer_id != auth()->id()) {
            abort(403);
        }

        return view('orders.print-invoice', compact('order'));
    }
}
