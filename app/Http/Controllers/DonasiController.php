<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    // Admin: list all donasi
    public function index(Request $request)
    {
        $query = Donasi::with('donatur')->latest('tanggal_donasi');

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $donasi = $query->paginate(15)->withQueryString();
        return view('donasi.index', compact('donasi'));
    }

    public function show(Donasi $donasi)
    {
        $donasi->load('donatur', 'bendahara');
        return view('donasi.show', compact('donasi'));
    }

    // Admin: approve donation
    public function verify(Donasi $donasi)
    {
        $donasi->update([
            'status_verifikasi' => 'Valid',
            'id_bendahara'      => Auth::user()->id_user,
        ]);

        $nama = $donasi->nama_donatur_display;
        return redirect()->route('donasi.index')->with('success', "Donasi dari {$nama} berhasil diverifikasi.");
    }

    // Admin: reject donation
    public function reject(Donasi $donasi)
    {
        $donasi->update([
            'status_verifikasi' => 'Tolak',
            'id_bendahara'      => Auth::user()->id_user,
        ]);

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil ditolak.');
    }

    public function destroy(Donasi $donasi)
    {
        if ($donasi->bukti_pembayaran) {
            Storage::disk('public')->delete($donasi->bukti_pembayaran);
        }
        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil dihapus.');
    }

    public function publicCreate()
    {
        return view('donasi.public');
    }

    // Public: store donasi from landing page (no auth required)
    public function publicStore(Request $request)
    {
        $request->validate([
            'nama_donatur'     => 'required|string|max:100',
            'nominal'          => 'required|numeric|min:10000',
            'metode'           => 'required|in:QRIS,Transfer,Tunai',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'nama_donatur.required'     => 'Nama donatur wajib diisi.',
            'nominal.required'          => 'Nominal donasi wajib diisi.',
            'nominal.min'               => 'Minimal donasi Rp 10.000.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes'    => 'File harus berformat JPG, PNG, atau PDF.',
            'bukti_pembayaran.max'      => 'Ukuran file maksimal 5MB.',
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        Donasi::create([
            'id_donatur'          => null,
            'nama_donatur_manual' => $request->nama_donatur,
            'nominal'             => $request->nominal,
            'metode_pembayaran'   => $request->metode,
            'bukti_pembayaran'    => $path,
            'status_verifikasi'   => 'Pending',
        ]);

        return back()->with('success', 'Terima kasih! Donasi Anda telah kami terima dan sedang dalam proses verifikasi.');
    }
}
