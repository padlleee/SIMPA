<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::query();
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_pengeluaran', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pengeluaran', $request->tahun);
        }
        $pengeluaran = $query->orderBy('tanggal_pengeluaran', 'desc')->paginate(15)->withQueryString();
        $totalBulanIni = Pengeluaran::whereMonth('tanggal_pengeluaran', now()->month)
                                    ->whereYear('tanggal_pengeluaran', now()->year)
                                    ->sum('nominal');
        return view('pengeluaran.index', compact('pengeluaran', 'totalBulanIni'));
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

        Pengeluaran::create(array_merge($request->all(), [
            'id_bendahara' => Auth::user()->id_user,
        ]));
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'tanggal_pengeluaran' => 'required|date',
            'kategori_biaya'      => 'required|string|max:50',
            'nominal'             => 'required|numeric|min:1',
            'keterangan'          => 'nullable|string',
        ]);

        $pengeluaran->update($request->all());
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
