<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;

class AnakAsuhController extends Controller
{
    public function index(Request $request)
    {
        $query = AnakAsuh::query();

        if ($request->filled('search')) {
            $query->where('nama_anak', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status_anak', $request->status);
        }

        $anakAsuh = $query->orderBy('nama_anak')->paginate(15)->withQueryString();
        return view('anak-asuh.index', compact('anakAsuh'));
    }

    public function create()
    {
        return view('anak-asuh.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anak'              => 'required|string|max:100',
            'tempat_lahir'           => 'nullable|string|max:50',
            'tanggal_lahir'          => 'required|date',
            'jenis_kelamin'          => 'required|in:L,P',
            'jenis_layanan'          => 'nullable|string|max:100',
            'dusun'                  => 'nullable|string|max:100',
            'rt'                     => 'nullable|string|max:10',
            'rw'                     => 'nullable|string|max:10',
            'desa'                   => 'nullable|string|max:100',
            'kecamatan'              => 'nullable|string|max:100',
            'status_anak'            => 'required|in:Aktif,Alumni',
            'tanggal_masuk'          => 'nullable|date',
            'catatan_kesehatan'      => 'nullable|string',
            'perkembangan_akademik'  => 'nullable|string',
        ]);

        AnakAsuh::create($request->all());
        return redirect()->route('anak-asuh.index')->with('success', 'Data anak asuh berhasil ditambahkan.');
    }

    public function show(AnakAsuh $anakAsuh)
    {
        return view('anak-asuh.show', compact('anakAsuh'));
    }

    public function edit(AnakAsuh $anakAsuh)
    {
        return view('anak-asuh.edit', compact('anakAsuh'));
    }

    public function update(Request $request, AnakAsuh $anakAsuh)
    {
        $request->validate([
            'nama_anak'              => 'required|string|max:100',
            'tempat_lahir'           => 'nullable|string|max:50',
            'tanggal_lahir'          => 'required|date',
            'jenis_kelamin'          => 'required|in:L,P',
            'jenis_layanan'          => 'nullable|string|max:100',
            'dusun'                  => 'nullable|string|max:100',
            'rt'                     => 'nullable|string|max:10',
            'rw'                     => 'nullable|string|max:10',
            'desa'                   => 'nullable|string|max:100',
            'kecamatan'              => 'nullable|string|max:100',
            'status_anak'            => 'required|in:Aktif,Alumni',
            'tanggal_masuk'          => 'nullable|date',
            'catatan_kesehatan'      => 'nullable|string',
            'perkembangan_akademik'  => 'nullable|string',
        ]);

        $anakAsuh->update($request->all());
        return redirect()->route('anak-asuh.index')->with('success', 'Data anak asuh berhasil diperbarui.');
    }

    public function destroy(AnakAsuh $anakAsuh)
    {
        $anakAsuh->delete();
        return redirect()->route('anak-asuh.index')->with('success', 'Data anak asuh berhasil dihapus.');
    }

    public function toggleStatus(AnakAsuh $anakAsuh)
    {
        $anakAsuh->status_anak = $anakAsuh->status_anak === 'Aktif' ? 'Alumni' : 'Aktif';
        $anakAsuh->save();

        $msg = $anakAsuh->status_anak === 'Alumni'
            ? "{$anakAsuh->nama_anak} telah dijadikan Alumni."
            : "{$anakAsuh->nama_anak} telah diaktifkan kembali.";

        return redirect()->route('anak-asuh.index')->with('success', $msg);
    }
}
