<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\KasMasuk;
use App\Models\RiwayatStok;
use App\Models\StokPanti;
use App\Models\User;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\DonationVerifiedMail;
use App\Mail\DonationRejectedMail;

class DonasiController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

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

        // Filter by type (member/public/sembako)
        $type = $request->get('type', 'all');
        if ($type === 'sembako') {
            $query->where('metode_pembayaran', 'Sembako / Barang');
        } else {
            // Untuk tab tunai (all, member, public), hide sembako
            $query->where('metode_pembayaran', '!=', 'Sembako / Barang');
            
            if ($type === 'member') {
                $query->whereNotNull('id_donatur');
            } elseif ($type === 'public') {
                $query->whereNull('id_donatur');
            }
        }

        $donasi = $query->paginate(15)->withQueryString();

        // Separate counts for tab badges
        $memberCount = Donasi::whereNotNull('id_donatur')->where('metode_pembayaran', '!=', 'Sembako / Barang')->count();
        $publicCount  = Donasi::whereNull('id_donatur')->where('metode_pembayaran', '!=', 'Sembako / Barang')->count();
        $sembakoCount = Donasi::where('metode_pembayaran', 'Sembako / Barang')->count();

        // Stats for summary cards in the view
        $stats = $this->getAdminStats();

        return view('donasi.index', compact('donasi', 'memberCount', 'publicCount', 'sembakoCount', 'type', 'stats'));
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
        $donasi->refresh();

        $autoLinked = false;

        // Celah 1 FIX: Jika donasi publik dan email cocok dengan akun terdaftar, auto-link
        if (is_null($donasi->id_donatur) && $donasi->email_donatur_manual) {
            $matchedUser = User::where('email', $donasi->email_donatur_manual)
                               ->where('role', 'Donatur')
                               ->first();
            if ($matchedUser) {
                $donasi->update([
                    'id_donatur'          => $matchedUser->id_user,
                    'nama_donatur_manual' => null,
                    'email_donatur_manual'=> null,
                    'no_hp_donatur_manual'=> null,
                ]);
                $donasi->refresh();
                $autoLinked = true;
            }
        }

        $nama  = $donasi->nama_donatur_display;
        $email = $donasi->user->email ?? $donasi->email_donatur_manual;

        $msg = "Donasi dari {$nama} (Rp " . number_format($donasi->nominal, 0, ',', '.') . ") berhasil diverifikasi.";
        if ($autoLinked) {
            $msg .= " Donasi telah otomatis dikaitkan ke akun terdaftar.";
        }

        if ($email) {
            try {
                Mail::to($email)->send(new DonationVerifiedMail([
                    'name'      => $nama,
                    'id_donasi' => $donasi->id_donasi,
                    'nominal'   => $donasi->nominal,
                    'metode'    => $donasi->metode_pembayaran,
                    'tanggal'   => $donasi->tanggal_verifikasi->format('d M Y H:i'),
                    'is_member' => $donasi->id_donatur ? true : false,
                ]));
                $msg .= " Email konfirmasi telah dikirim.";
            } catch (\Exception $e) {
                $msg .= " (Gagal mengirim email konfirmasi).";
            }
        }

        return redirect()->route('donasi.index')->with('success', $msg);
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

        $nama = $donasi->nama_donatur_display;
        $email = $donasi->user->email ?? $donasi->email_donatur_manual;
        
        $msg = "Donasi berhasil ditolak dengan catatan disimpan.";

        if ($email) {
            try {
                Mail::to($email)->send(new DonationRejectedMail([
                    'name' => $nama,
                    'nominal' => $donasi->nominal,
                    'catatan' => $request->catatan,
                ]));
                $msg .= " Email penolakan telah dikirim.";
            } catch (\Exception $e) {
                $msg .= " (Gagal mengirim email penolakan).";
            }
        }

        return redirect()->route('donasi.index')->with('success', $msg);
    }

    public function destroy(Donasi $donasi)
    {
        // Hapus file bukti pembayaran dari storage jika ada
        $this->imageService->deleteOldImage($donasi->bukti_pembayaran);

        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil dihapus.');
    }

    /**
     * Admin: Show create cash donation form
     * Supports two donation types:
     *  - 'uang'    : Regular cash donation (default)
     *  - 'sembako' : In-kind grocery donation that auto-inserts into stok_panti (Gudang)
     */
    public function adminCreate()
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // Pass existing stok items so the form can optionally link to an existing entry
        $stokList = StokPanti::orderBy('nama_barang')->pluck('nama_barang', 'id_stok');

        return view('donasi.admin-create', compact('stokList'));
    }

    /**
     * Admin: Store cash or in-kind (sembako) donation manually.
     *
     * When jenis_donasi = 'sembako', the system will:
     *  1. Record the Donasi row as usual (nominal = estimated value).
     *  2. Upsert the corresponding StokPanti row using a FIFO/batch approach:
     *     - If a row for the item already exists → add barang_masuk to the existing batch.
     *     - If not → create a new stok row for this batch.
     *  3. Write a RiwayatStok entry for full traceability.
     *  All three writes are wrapped in a DB::transaction for atomicity.
     */
    public function adminStore(Request $request)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // Resolve the custom PK — Auth::id() returns null when primaryKey != 'id'
        $adminId = Auth::user()->id_user;

        $sembako = $request->input('jenis_donasi') === 'sembako';

        // ── Validation ───────────────────────────────────────────────────
        $baseRules = [
            'jenis_donasi'   => 'required|in:uang,sembako',
            'nama_donatur'   => 'required|string|max:150',
            'tanggal_donasi' => 'required|date',
        ];

        if ($sembako) {
            $baseRules = array_merge($baseRules, [
                'nama_barang'        => 'required|string|max:150',
                'merk'               => 'nullable|string|max:100',
                'jumlah'             => 'required|integer|min:1',
                'satuan'             => 'required|string|max:20',
                'tanggal_kadaluarsa' => 'nullable|date|after_or_equal:today',
                'nominal'            => 'nullable|numeric|min:0',
            ]);
        } else {
            $baseRules['nominal'] = 'required|numeric|min:1000';
        }

        $request->validate($baseRules, [
            'nama_barang.required' => 'Nama barang wajib diisi untuk donasi sembako.',
            'jumlah.required'      => 'Jumlah barang wajib diisi.',
            'jumlah.min'           => 'Jumlah barang minimal 1.',
            'satuan.required'      => 'Satuan barang wajib dipilih.',
            'nominal.min'          => 'Minimal donasi tunai Rp 1.000.',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create the Donasi record ──────────────────────────────────
            $catatan = $sembako
                ? 'Donasi Sembako: ' . trim($request->nama_barang)
                  . ' (' . $request->jumlah . ' ' . $request->satuan . ')'
                  . ($request->merk ? ' — ' . $request->merk : '')
                : 'Rekap tunai oleh Admin';

            $donasi = Donasi::create([
                'nama_donatur_manual' => $request->nama_donatur,
                'nominal'             => $request->nominal ?? 0,
                'metode_pembayaran'   => $sembako ? 'Sembako / Barang' : 'Tunai',
                'status_verifikasi'   => 'Valid',
                'id_bendahara'        => $adminId,
                'tanggal_donasi'      => $request->tanggal_donasi,
                'tanggal_verifikasi'  => now(),
                'catatan_verifikasi'  => $catatan,
            ]);

            // 2. Gudang — one-item-one-code (satu barang satu kode) ────────
            // Match by nama_barang only. If merk/expiry differ from a new
            // donation, the existing row is updated rather than duplicated.
            if ($sembako) {
                $namaBarang = trim($request->nama_barang);
                $merk       = $request->merk ?: null;
                $jumlah     = (int) $request->jumlah;
                $satuan     = $request->satuan;
                $kadaluarsa = $request->tanggal_kadaluarsa ?: null;

                // Sistem Batch FIFO: cari stok yang memiliki nama, merk & kadaluarsa persis sama
                $existingStok = StokPanti::where('nama_barang', $namaBarang)
                    ->when($merk, fn($q) => $q->where('merk', $merk))
                    ->when(
                        $kadaluarsa,
                        fn($q) => $q->whereDate('tanggal_kadaluarsa', $kadaluarsa),
                        fn($q) => $q->whereNull('tanggal_kadaluarsa')
                    )
                    ->first();

                if ($existingStok) {
                    $stokSebelum = $existingStok->stok_akhir;
                    $stokSesudah = $stokSebelum + $jumlah;

                    $existingStok->update([
                        'barang_masuk' => $existingStok->barang_masuk + $jumlah,
                        'stok_akhir'   => $stokSesudah,
                    ]);
                    $stokRef = $existingStok->fresh();

                } else {
                    $stokSebelum = 0;
                    $stokSesudah = $jumlah;

                    $stokRef = StokPanti::create([
                        'nama_barang'        => $namaBarang,
                        'kode_barang'        => \App\Models\StokPanti::generateKodeBarang(),
                        'kategori_barang'    => 'Sembako',
                        'merk'               => $merk,
                        'satuan'             => $satuan,
                        'stok_awal'          => $jumlah,
                        'barang_masuk'       => $jumlah,
                        'barang_keluar'      => 0,
                        'stok_akhir'         => $jumlah,
                        'tanggal_kadaluarsa' => $kadaluarsa,
                        'keterangan'         => 'Donasi sembako dari ' . $request->nama_donatur,
                        'id_admin'           => $adminId,
                    ]);
                }

                // 3. Riwayat Gudang ────────────────────────────────────────
                RiwayatStok::create([
                    'id_stok'         => $stokRef->id_stok,
                    'nama_barang'     => $namaBarang,
                    'kategori_barang' => 'Sembako',
                    'satuan'          => $satuan,
                    'jenis'           => 'Masuk',
                    'jumlah'          => $jumlah,
                    'stok_sebelum'    => $stokSebelum,
                    'stok_sesudah'    => $stokSesudah,
                    'keterangan'      => '[Donasi Sembako #' . $donasi->id_donasi . '] '
                                       . $jumlah . ' ' . $satuan . ' ' . $namaBarang
                                       . ($merk ? ' (' . $merk . ')' : '')
                                       . ' dari ' . $request->nama_donatur,
                    'id_admin'        => $adminId,
                    'created_at'      => now(),
                ]);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('adminStore Donasi failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token']),
            ]);
            return redirect()->back()->withInput()
                             ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }

        $msg = $sembako
            ? 'Donasi Sembako dari ' . $request->nama_donatur . ' berhasil dicatat dan stok gudang diperbarui.'
            : 'Rekap donasi tunai dari ' . $request->nama_donatur . ' berhasil ditambahkan.';

        return redirect()->route('donasi.index')->with('success', $msg);
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

        // Optimasi & simpan bukti transfer: konversi webp 65% quality, maks 1200px
        try {
            $filePath = $this->imageService->optimizeReceiptImage($request->file('bukti_pembayaran'));
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Gagal memproses file bukti pembayaran. Pastikan file adalah gambar (JPG/PNG) yang valid.');
        }

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

        // Optimasi & simpan bukti transfer: konversi webp 65% quality, maks 1200px
        try {
            $filePath = $this->imageService->optimizeReceiptImage($request->file('bukti_pembayaran'));
        } catch (\Exception $e) {
            return back()->withInput()
                         ->with('error', 'Gagal memproses file bukti pembayaran. Pastikan file adalah gambar (JPG/PNG) yang valid.');
        }

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
            'pending'                  => Donasi::pending()->count(),
            'verified'                 => Donasi::verified()->count(),
            'rejected'                 => Donasi::tolak()->count(),
            'totalDonations'           => Donasi::verified()->sum('nominal'),
            'totalDonations_formatted' => 'Rp ' . number_format(Donasi::verified()->sum('nominal'), 0, ',', '.'),
        ];
    }

    /**
     * Admin: Ringkasan donasi dikelompokkan per donatur
     */
    public function byDonor(Request $request)
    {
        if (!in_array(Auth::user()->role, ['Admin', 'Ketua', 'Bendahara'])) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // Donatur Terdaftar — group by id_donatur
        $memberDonors = DB::table('donasi')
            ->join('users', 'donasi.id_donatur', '=', 'users.id_user')
            ->leftJoin('donatur', 'users.id_user', '=', 'donatur.id_user')
            ->select(
                'users.id_user',
                DB::raw('COALESCE(donatur.nama_donatur, users.username) as nama'),
                'users.email',
                'donatur.no_hp',
                DB::raw('COUNT(donasi.id_donasi) as jumlah_donasi'),
                DB::raw('SUM(CASE WHEN donasi.status_verifikasi = \'Valid\' THEN donasi.nominal ELSE 0 END) as total_valid'),
                DB::raw('MAX(donasi.tanggal_donasi) as terakhir_donasi')
            )
            ->whereNotNull('donasi.id_donatur')
            ->groupBy('users.id_user', 'nama', 'users.email', 'donatur.no_hp')
            ->orderByDesc('total_valid')
            ->get();

        // Donatur Publik — group by email_donatur_manual
        $publicDonors = DB::table('donasi')
            ->select(
                'nama_donatur_manual as nama',
                'email_donatur_manual as email',
                'no_hp_donatur_manual as no_hp',
                DB::raw('COUNT(id_donasi) as jumlah_donasi'),
                DB::raw('SUM(CASE WHEN status_verifikasi = \'Valid\' THEN nominal ELSE 0 END) as total_valid'),
                DB::raw('MAX(tanggal_donasi) as terakhir_donasi')
            )
            ->whereNull('id_donatur')
            ->whereNotNull('email_donatur_manual')
            ->groupBy('nama_donatur_manual', 'email_donatur_manual', 'no_hp_donatur_manual')
            ->orderByDesc('total_valid')
            ->get();

        $grandTotal = Donasi::verified()->sum('nominal');

        return view('donasi.by-donor', compact('memberDonors', 'publicDonors', 'grandTotal'));
    }
}
