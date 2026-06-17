<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageOptimizationService
{
    /**
     * Proses gambar Blog/Kegiatan (BeritaController).
     *
     * - Resize ke lebar maksimal 1000px (jaga aspek rasio, cegah upsizing)
     * - Konversi ke .webp, kualitas 75%
     * - Simpan ke storage/app/public/img/blog/
     *
     * @param  UploadedFile $file
     * @return string  Path relatif yang tersimpan (disimpan di DB)
     */
    public function optimizeBlogImage(UploadedFile $file): string
    {
        $filename  = time() . '_' . Str::random(8) . '.webp';
        $directory = 'img/blog';

        $image = Image::make($file)
            ->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // mencegah upsizing
            });

        return $this->saveToStorage($image, $directory, $filename, 75);
    }

    /**
     * Proses gambar inline untuk artikel blog (Trix Editor).
     *
     * - Resize ke lebar maksimal 1200px (jaga aspek rasio, cegah upsizing)
     * - Konversi ke .webp, kualitas 75%
     * - Simpan ke storage/app/public/img/blog_inline/
     *
     * @param  UploadedFile $file
     * @return string  Path relatif yang tersimpan
     */
    public function optimizeBlogInlineImage(UploadedFile $file): string
    {
        $filename  = time() . '_inline_' . Str::random(8) . '.webp';
        $directory = 'img/blog_inline';

        $image = Image::make($file)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        return $this->saveToStorage($image, $directory, $filename, 75);
    }

    /**
     * Proses gambar profil Anak Asuh / User (AnakAsuhController / UserController).
     *
     * - Crop/fit ke ukuran persegi 400×400px
     * - Konversi ke .webp, kualitas 70%
     * - Simpan ke storage/app/public/img/profiles/
     *
     * @param  UploadedFile $file
     * @return string  Path relatif yang tersimpan (disimpan di DB)
     */
    public function optimizeProfileImage(UploadedFile $file): string
    {
        $filename  = time() . '_' . Str::random(8) . '.webp';
        $directory = 'img/profiles';

        $image = Image::make($file)
            ->fit(400, 400); // crop presisi ke 1:1 square

        return $this->saveToStorage($image, $directory, $filename, 70);
    }

    /**
     * Proses gambar bukti transfer Donasi (DonasiController).
     *
     * - Pertahankan dimensi asli, batasi lebar maks 1200px jika melebihi
     * - Konversi ke .webp, kualitas 65%
     * - Simpan ke storage/app/public/img/receipts/
     *
     * @param  UploadedFile $file
     * @return string  Path relatif yang tersimpan (disimpan di DB)
     */
    public function optimizeReceiptImage(UploadedFile $file): string
    {
        $filename  = time() . '_' . Str::random(8) . '.webp';
        $directory = 'img/receipts';

        $image = Image::make($file)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // hanya resize jika lebar > 1200px
            });

        return $this->saveToStorage($image, $directory, $filename, 65);
    }

    /**
     * Hapus file lama dari storage jika ada.
     * Gunakan ini sebelum menyimpan file baru pada operasi update.
     *
     * @param  string|null $path  Path relatif file lama yang tersimpan di DB
     * @return void
     */
    public function deleteOldImage(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Helper internal: encode gambar ke webp dan simpan ke storage.
     *
     * @param  \Intervention\Image\Image $image
     * @param  string                    $directory  Direktori relatif (tanpa leading slash)
     * @param  string                    $filename   Nama file dengan ekstensi .webp
     * @param  int                       $quality    Persentase kualitas kompresi (1-100)
     * @return string                    Path relatif yang tersimpan (contoh: 'img/blog/123_abc.webp')
     */
    private function saveToStorage($image, string $directory, string $filename, int $quality): string
    {
        // Pastikan direktori ada di storage publik
        Storage::disk('public')->makeDirectory($directory);

        $fullPath = storage_path("app/public/{$directory}/{$filename}");

        // Encode ke webp dengan kualitas yang ditentukan, lalu simpan
        $image->encode('webp', $quality)->save($fullPath);

        // Kembalikan path relatif untuk disimpan di database
        return "{$directory}/{$filename}";
    }
}
