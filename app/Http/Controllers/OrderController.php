<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan halaman create transaksi.
     */
    public function index()
    {
        $orders = Order::all(); // Ambil semua order dari database
        return view('transaksi.create', compact('orders'));
    }

    /**
     * Menampilkan halaman laporan transaksi.
     */
    public function index1()
    {
        $orders = Order::all();
        return view('LaporanTransaksi.index', compact('orders'));
    }

    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu!');
        }

        $user_id = Auth::id(); // Ambil ID user yang login

        $data = $request->validate([
            'barang' => 'required|array',
            'barang.*.product_id' => 'nullable|integer',
            'barang.*.nama' => 'required|string',
            'barang.*.quantity' => 'required|integer|min:1',
            'barang.*.price' => 'required|numeric|min:0',
        ]);

        // Buat Order baru
        $order = Order::create([
            'user_id' => $user_id, // Pastikan ID user tidak null
            'status' => 'pending',
            'total_price' => 0,
        ]);

        $total_price = 0;

        foreach ($data['barang'] as $barang) {
            $total_harga = $barang['quantity'] * $barang['price'];
            $total_price += $total_harga;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $barang['product_id'] ?? null,
                'nama' => $barang['nama'],
                'quantity' => $barang['quantity'],
                'price' => $barang['price'],
                'total_price' => $total_harga,
            ]);
        }

        // Update total_price setelah semua item ditambahkan
        $order->update(['total_price' => $total_price]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Menampilkan detail transaksi tertentu.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Menampilkan form edit transaksi tertentu.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update transaksi tertentu.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Hapus transaksi tertentu.
     */
    public function destroy(Order $order)
    {
        //
    }

    /**
     * Mengambil data untuk laporan dalam bentuk chart.
     */
    public function getChartData()
    {
        $data = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(id) as jumlah_transaksi'),
            DB::raw('SUM(total_price) as total_pendapatan')
        )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($data);
    }

    public function exportPdf()
    {
        $orders = Order::all(); // Ambil semua data order

        $pdf = Pdf::loadView('LaporanTransaksi.pdf', compact('orders')); // Gunakan blade khusus untuk PDF
        return $pdf->download('laporan_transaksi.pdf'); // Download PDF
    }
}
