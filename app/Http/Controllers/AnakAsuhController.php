<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use App\Models\Label;
use App\Models\PrestasiAnak;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;

class AnakAsuhController extends Controller
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

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
            'pendidikan'             => 'nullable|string|max:50',
            'kelas'                  => 'nullable|string|max:50',
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
            'foto_profil'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            try {
                // Optimasi: crop 400×400px persegi, konversi webp 70% quality
                $data['foto_profil'] = $this->imageService->optimizeProfileImage($request->file('foto_profil'));
            } catch (\Exception $e) {
                return back()->withInput()
                             ->with('error', 'Gagal memproses foto profil. Pastikan file adalah gambar yang valid. (' . $e->getMessage() . ')');
            }
        }

        AnakAsuh::create($data);
        return redirect()->route('anak-asuh.index')->with('success', 'Data anak asuh berhasil ditambahkan.');
    }

    public function show(AnakAsuh $anakAsuh)
    {
        return view('anak-asuh.show', compact('anakAsuh'));
    }

    public function edit(AnakAsuh $anakAsuh)
    {
        $availableLabels = Label::orderBy('nama_label')->get();
        return view('anak-asuh.edit', compact('anakAsuh', 'availableLabels'));
    }

    public function update(Request $request, AnakAsuh $anakAsuh)
    {
        $request->validate([
            'nama_anak'              => 'required|string|max:100',
            'tempat_lahir'           => 'nullable|string|max:50',
            'tanggal_lahir'          => 'required|date',
            'jenis_kelamin'          => 'required|in:L,P',
            'pendidikan'             => 'nullable|string|max:50',
            'kelas'                  => 'nullable|string|max:50',
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
            'foto_profil'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            try {
                // Hapus foto lama, simpan yang baru (optimized)
                $this->imageService->deleteOldImage($anakAsuh->foto_profil);
                $data['foto_profil'] = $this->imageService->optimizeProfileImage($request->file('foto_profil'));
            } catch (\Exception $e) {
                return back()->withInput()
                             ->with('error', 'Gagal memproses foto profil. Pastikan file adalah gambar yang valid. (' . $e->getMessage() . ')');
            }
        }

        $anakAsuh->update($data);

        // Sync label tags (label_ids[] from hidden inputs)
        if ($request->has('label_ids')) {
            $anakAsuh->labels()->sync($request->input('label_ids', []));
        } else {
            // If key absent (no labels selected), detach all
            $anakAsuh->labels()->sync([]);
        }

        return redirect()->route('anak-asuh.index')->with('success', 'Data anak asuh berhasil diperbarui.');
    }

    public function destroy(AnakAsuh $anakAsuh)
    {
        $this->imageService->deleteOldImage($anakAsuh->foto_profil);
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

    // ── AJAX: Prestasi Anak ────────────────────────────────────────────

    /**
     * AJAX POST: Add a new free-text achievement badge to an orphan.
     * Returns JSON {id, teks_prestasi, warna_hex} on success.
     */
    public function addPrestasi(Request $request, AnakAsuh $anakAsuh)
    {
        $request->validate([
            'teks_prestasi'  => 'required|string|max:200',
            'tanggal_dicatat'=> 'nullable|date',
        ]);

        // Auto-assign colour based on how many prestasi the child already has
        $count  = $anakAsuh->prestasi()->count();
        $warna  = PrestasiAnak::warnaUntukIndex($count);

        $prestasi = $anakAsuh->prestasi()->create([
            'teks_prestasi'   => trim($request->teks_prestasi),
            'tanggal_dicatat' => $request->tanggal_dicatat ?: now()->toDateString(),
            'warna_hex'       => $warna,
        ]);

        return response()->json([
            'success'   => true,
            'id'        => $prestasi->id,
            'teks'      => $prestasi->teks_prestasi,
            'warna'     => $prestasi->warna_hex,
            'tanggal'   => $prestasi->tanggal_dicatat?->format('d M Y'),
        ]);
    }

    /**
     * AJAX DELETE: Remove an achievement badge from an orphan.
     */
    public function deletePrestasi(AnakAsuh $anakAsuh, PrestasiAnak $prestasi)
    {
        // Safety: ensure prestasi belongs to this anak
        if ($prestasi->anak_asuh_id !== $anakAsuh->id_anak) {
            return response()->json(['success' => false, 'message' => 'Not found.'], 404);
        }

        $prestasi->delete();
        return response()->json(['success' => true]);
    }
}
