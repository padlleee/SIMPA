<?php

namespace App\Http\Controllers;

use App\Models\CalonAnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranAnakController extends Controller
{
    // ─── PUBLIC ──────────────────────────────────────────────────────────────

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anak'      => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date|before:today',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'nama_wali'      => 'required|string|max:100',
            'kontak_wali'    => 'required|string|max:20',
            'alasan_masuk'   => 'required|string|min:30',
            'dokumen'        => 'nullable|file|mimes:pdf,zip|max:10240', // max 10 MB
        ], [
            'tanggal_lahir.before'  => 'Tanggal lahir harus sebelum hari ini.',
            'alasan_masuk.min'      => 'Alasan masuk minimal 30 karakter.',
            'dokumen.mimes'         => 'Dokumen harus berupa file PDF atau ZIP.',
            'dokumen.max'           => 'Ukuran dokumen maksimal 10 MB.',
        ]);

        $dokumenPath = null;
        if ($request->hasFile('dokumen')) {
            $dokumenPath = $request->file('dokumen')->store('pendaftaran', 'public');
        }

        CalonAnakAsuh::create([
            'nama_anak'     => $request->nama_anak,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_wali'     => $request->nama_wali,
            'kontak_wali'   => $request->kontak_wali,
            'alasan_masuk'  => $request->alasan_masuk,
            'dokumen_path'  => $dokumenPath,
            'status'        => 'Pending',
        ]);

        return redirect()->route('pendaftaran-anak.create')
                         ->with('success', 'Formulir pendaftaran berhasil dikirim! Tim kami akan meninjau pengajuan Anda dalam 3–5 hari kerja.');
    }

    // ─── ADMIN ───────────────────────────────────────────────────────────────

    public function adminIndex(Request $request)
    {
        $query = CalonAnakAsuh::with('reviewer')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(15);
        return view('admin.pendaftaran.index', compact('registrations'));
    }

    public function approve(CalonAnakAsuh $calon)
    {
        $calon->update([
            'status'      => 'Disetujui',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', "Pendaftaran atas nama {$calon->nama_anak} telah disetujui.");
    }

    public function reject(Request $request, CalonAnakAsuh $calon)
    {
        $request->validate([
            'catatan_review' => 'nullable|string|max:500',
        ]);

        $calon->update([
            'status'         => 'Ditolak',
            'reviewed_by'    => Auth::id(),
            'reviewed_at'    => now(),
            'catatan_review' => $request->catatan_review,
        ]);

        return back()->with('success', "Pendaftaran atas nama {$calon->nama_anak} telah ditolak.");
    }
}
