<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('transaksi.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'barang' => 'required|array',
            'barang.*.product_id' => 'nullable|integer',
            'barang.*.nama' => 'required|string',
            'barang.*.quantity' => 'required|integer|min:1',
            'barang.*.price' => 'required|numeric|min:0',
        ]);
        $user = Auth::user();
        $user_id = $user->id;        // Buat Order baru
        $order = Order::create([
            'user_id' => $user_id,
            'status' => 'pending',
            'total_price' => 0, // Awalnya 0, nanti di-update
        ]);

        $total_price = 0;

        foreach ($data['barang'] as $barang) {
            $total_harga = $barang['quantity'] * $barang['price'];
            $total_price += $total_harga;

            OrderItem::create([
                'order_id' => $order->id, // Hubungkan dengan Order
                'product_id' => $barang['product_id'] ?? null,
                'nama' => $barang['nama'],
                'quantity' => $barang['quantity'],
                'price' => $barang['price'],
                'total_price' => $total_harga,
            ]);
        }

        // Update total_price di Order setelah semua item ditambahkan
        $order->update(['total_price' => $total_price]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
