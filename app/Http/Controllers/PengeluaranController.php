<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with('bendahara');
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pengeluaran', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pengeluaran', $request->tahun);
        }
        $pengeluaran = $query->orderBy('tanggal_pengeluaran', 'desc')->paginate(15)->withQueryString();
        
        $totalPengeluaran = (clone $query)->sum('nominal');
        
        return view('pengeluaran.index', compact('pengeluaran', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'kategori_biaya'      => 'required|string|max:50',
            'nominal'             => 'required|numeric|min:1',
            'keterangan'          => 'nullable|string',
        ]);

        $totalDonasi = \App\Models\Donasi::valid()->sum('nominal');
        $totalPengeluaran = Pengeluaran::sum('nominal');
        $saldo = $totalDonasi - $totalPengeluaran;

        if ($request->nominal > $saldo) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nominal' => 'Saldo saat ini tidak mencukupi. Saldo tersedia: Rp ' . number_format($saldo, 0, ',', '.')]);
        }

        Pengeluaran::create(array_merge($request->all(), [
            'id_bendahara' => Auth::user()->id_user,
        ]));
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function show(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    // Edit and update removed as per user request

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
