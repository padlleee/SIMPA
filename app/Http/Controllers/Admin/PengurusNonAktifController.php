<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengurusNonAktif;

class PengurusNonAktifController extends Controller
{
    public function index()
    {
        $pengurus = PengurusNonAktif::orderBy('created_at', 'desc')->get();
        return view('pengurus-nonaktif.index', compact('pengurus'));
    }

    public function create()
    {
        return view('pengurus-nonaktif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan_terakhir' => 'nullable|string|max:255',
            'tahun_nonaktif' => 'nullable|string|max:4'
        ]);

        PengurusNonAktif::create($request->all());

        return redirect()->route('admin.pengurus-nonaktif.index')->with('success', 'Data pengurus non-aktif berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $pengurus = PengurusNonAktif::findOrFail($id);
        $pengurus->delete();

        return redirect()->back()->with('success', 'Data pengurus non-aktif berhasil dihapus.');
    }
}
