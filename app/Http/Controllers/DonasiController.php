<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    // ==================== ADMIN - MANAGEMENT ====================

    /**
     * Admin dashboard: List all donations with status filter
     */
    public function index(Request $request)
    {
        $query = Donasi::with('user.donatur', 'bendahara')->latest('tanggal_donasi');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_donasi', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_donasi', '<=', $request->sampai_tanggal);
        }

        // Filter by type (member/public)
        $type = $request->get('type', 'all');
        if ($type === 'member') {
            $query->whereNotNull('id_donatur');
        } elseif ($type === 'public') {
            $query->whereNull('id_donatur');
        }

        $donasi = $query->paginate(15)->withQueryString();

        // Separate counts for tab badges
        $memberCount = Donasi::whereNotNull('id_donatur')->count();
        $publicCount  = Donasi::whereNull('id_donatur')->count();

        return view('donasi.index', compact('donasi', 'memberCount', 'publicCount', 'type'));
    }

    /**
     * Show single donation detail for verification
     */
    public function show(Donasi $donasi)
    {
        $donasi->load('user.donatur', 'bendahara');
        return view('donasi.show', compact('donasi'));
    }

    /**
     * Admin: Verify (approve) donation
     */
    public function verify(Request $request, Donasi $donasi)
    {
        // Only admins can verify
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk verifikasi donasi.');
        }

        // Validate request
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);

        // Verify donation
        $donasi->verify(Auth::user()->id_user, $request->catatan);

        $nama = $donasi->nama_donatur_display;
        return redirect()->route('donasi.index')
            ->with('success', "Donasi dari {$nama} (Rp " . number_format($donasi->nominal, 0, ',', '.') . ") berhasil diverifikasi.");
    }

    /**
     * Admin: Reject donation
     */
    public function reject(Request $request, Donasi $donasi)
    {
        // Only admins can reject
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menolak donasi.');
        }

        // Validate request
        $request->validate([
            'catatan' => 'required|string|max:500',
        ], [
            'catatan.required' => 'Catatan penolakan harus diisi.',
        ]);

        // Reject donation
        $donasi->reject(Auth::user()->id_user, $request->catatan);

        return redirect()->route('donasi.index')
            ->with('success', 'Donasi berhasil ditolak dengan catatan disimpan.');
    }

    public function destroy(Donasi $donasi)
    {
        // Delete uploaded file if exists
        if ($donasi->bukti_pembayaran && Storage::disk('public')->exists($donasi->bukti_pembayaran)) {
            Storage::disk('public')->delete($donasi->bukti_pembayaran);
        }

        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil dihapus.');
    }

    /**
     * Admin: Show create cash donation form
     */
    public function adminCreate()
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        return view('donasi.admin-create');
    }

    /**
     * Admin: Store cash donation manually
     */
    public function adminStore(Request $request)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'nama_donatur' => 'required|string|max:150',
            'nominal' => 'required|numeric|min:1000',
            'tanggal_donasi' => 'required|date',
        ]);

        Donasi::create([
            'nama_donatur_manual' => $request->nama_donatur,
            'nominal' => $request->nominal,
            'metode_pembayaran' => 'Tunai',
            'status_verifikasi' => 'Valid',
            'id_bendahara' => Auth::id(),
            'tanggal_donasi' => $request->tanggal_donasi,
            'tanggal_verifikasi' => now(),
            'catatan_verifikasi' => 'Rekap tunai oleh Admin',
        ]);

        return redirect()->route('donasi.index')->with('success', 'Rekap donasi tunai berhasil ditambahkan.');
    }

    // ==================== PUBLIC - DONATION FORM ====================

    /**
     * Show public donation form
     */
    public function publicCreate()
    {
        return view('donasi.public-create');
    }

    /**
     * Store public donation (no authentication required)
     */
    public function publicStore(Request $request)
    {
        // Validate input
        $request->validate([
            'nama_donatur' => 'required|string|max:150',
            'email' => 'required|email|max:120',
            'no_hp' => 'nullable|string|max:20',
            'nominal' => 'required|numeric|min:10000',
            'metode' => 'required|in:Transfer,QRIS,BJB,BRI',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nama_donatur.required' => 'Nama donatur wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus format yang valid (contoh: nama@email.com).',
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.min' => 'Minimal donasi Rp 10.000.',
            'metode.required' => 'Metode pembayaran harus dipilih.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes' => 'File harus berformat JPG, PNG, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Store file
        $filePath = $request->file('bukti_pembayaran')->store('donasi/bukti_pembayaran', 'public');

        // Create donation record
        Donasi::create([
            'nama_donatur_manual' => $request->nama_donatur,
            'email_donatur_manual' => $request->email,
            'no_hp_donatur_manual' => $request->no_hp,
            'nominal' => $request->nominal,
            'metode_pembayaran' => $request->metode,
            'bukti_pembayaran' => $filePath,
            'status_verifikasi' => 'Pending',
            'tanggal_donasi' => now(),
        ]);

        return redirect()->route('donasi.public.success')
            ->with('success', 'Donasi Anda telah diterima. Tim kami akan memverifikasi dalam 1x24 jam.');
    }

    /**
     * Show donation success page
     */
    public function publicSuccess()
    {
        return view('donasi.public-success');
    }

    // ==================== REGISTERED DONOR - DONATION FORM ====================

    /**
     * Show donation form for authenticated donors
     */
    public function userCreate()
    {
        $user    = Auth::user();
        $donatur = $user->donatur;
        return view('donasi.user-create', compact('user', 'donatur'));
    }

    /**
     * Store donation for authenticated donors
     */
    public function userStore(Request $request)
    {
        // Validate input
        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'metode' => 'required|in:Transfer,QRIS,BJB,BRI',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.min' => 'Minimal donasi Rp 10.000.',
            'metode.required' => 'Metode pembayaran harus dipilih.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes' => 'File harus berformat JPG, PNG, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Store file
        $filePath = $request->file('bukti_pembayaran')->store('donasi/bukti_pembayaran', 'public');

        // Create donation record linked to user
        Donasi::create([
            'id_donatur' => Auth::id(),
            'nominal' => $request->nominal,
            'metode_pembayaran' => $request->metode,
            'bukti_pembayaran' => $filePath,
            'status_verifikasi' => 'Pending',
            'tanggal_donasi' => now(),
        ]);

        return redirect()->route('donatur.dashboard')
            ->with('success', 'Donasi Anda telah dikirim dan sedang menunggu verifikasi.');
    }

    // ==================== RECEIPT - DIGITAL RECEIPT ====================

    /**
     * Generate and display digital receipt for donor
     */
    public function showReceipt(Donasi $donasi)
    {
        // Only show receipt if verified
        if (!$donasi->isVerified()) {
            return redirect()->back()
                ->with('error', 'Kwitansi hanya tersedia untuk donasi yang telah diverifikasi.');
        }

        // Authorization check
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['Admin', 'Ketua', 'Bendahara']);
        if (!$isAdmin && $donasi->id_donatur !== $user->id_user) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat kwitansi ini.');
        }

        // Load relations
        $donasi->load('user.donatur', 'bendahara');

        return view('donasi.receipt', compact('donasi'));
    }

    /**
     * Download receipt as PDF (future enhancement)
     * For now, users can use browser print-to-PDF feature
     */
    public function downloadReceipt(Donasi $donasi)
    {
        if (!$donasi->isVerified()) {
            return redirect()->back()->with('error', 'Hanya donasi yang terverifikasi yang dapat diunduh.');
        }

        // Authorization check
        $user = Auth::user();
        $isAdmin = in_array($user->role, ['Admin', 'Ketua', 'Bendahara']);
        if (!$isAdmin && $donasi->id_donatur !== $user->id_user) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat kwitansi ini.');
        }

        // TODO: Implement PDF generation using tcpdf or barryvdh/laravel-dompdf
        return $this->showReceipt($donasi);
    }

    // ==================== PUBLIC STATS ====================

    /**
     * Get donation progress statistics for landing page
     */
    public function getPublicStats()
    {
        $totalVerified = Donasi::verified()->sum('nominal');
        $donationGoal = env('DONATION_GOAL', 50000000);
        $percentage = min(100, ceil(($totalVerified / $donationGoal) * 100));

        return [
            'totalVerified' => $totalVerified,
            'donationGoal' => $donationGoal,
            'percentage' => $percentage,
        ];
    }

    /**
     * Get summary statistics for admin dashboard
     */
    public function getAdminStats()
    {
        return [
            'pending' => Donasi::pending()->count(),
            'verified' => Donasi::verified()->count(),
            'rejected' => Donasi::tolak()->count(),
            'totalDonations' => Donasi::verified()->sum('nominal'),
            'totalDonations_formatted' => 'Rp ' . number_format(Donasi::verified()->sum('nominal'), 0, ',', '.'),
        ];
    }
}
