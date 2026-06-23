<?php

namespace App\Imports;

use App\Models\Perpustakaan;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PerpustakaanImport
{
    public int $inserted = 0;
    public int $skipped  = 0;
    public array $errors = [];

    private array $validKondisi = ['Baik', 'Cukup', 'Rusak'];

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, false);

        foreach (array_slice($rows, 1) as $rowIndex => $row) {
            $lineNumber = $rowIndex + 2;

            if (empty(trim((string)($row[0] ?? '')))) continue;

            try {
                $judulBuku = trim((string)($row[0] ?? ''));
                if (empty($judulBuku)) {
                    $this->errors[] = "Baris {$lineNumber}: Judul buku wajib diisi.";
                    $this->skipped++;
                    continue;
                }

                $pengarang    = trim((string)($row[1] ?? ''));
                $penerbit     = trim((string)($row[2] ?? ''));
                $tahunTerbit  = trim((string)($row[3] ?? ''));
                $isbn         = trim((string)($row[4] ?? ''));
                $kategori     = trim((string)($row[5] ?? 'Umum')) ?: 'Umum';
                $jumlahBuku   = max(1, (int)($row[6] ?? 1));
                $kondisiBuku  = trim((string)($row[7] ?? 'Baik'));
                if (!in_array($kondisiBuku, $this->validKondisi)) $kondisiBuku = 'Baik';
                $sinopsis     = trim((string)($row[8] ?? ''));

                // Generate kode buku otomatis menggunakan format yang sama dengan controller (BUK-XXXX)
                $lastBuku  = Perpustakaan::orderBy('id_buku', 'desc')->first();
                if ($lastBuku && preg_match('/BUK-(\d+)/', $lastBuku->kode_buku, $m)) {
                    $seq = intval($m[1]) + 1 + $this->inserted; // offset agar tidak duplikat
                } else {
                    $seq = ($lastBuku ? $lastBuku->id_buku + 1 : 1) + $this->inserted;
                }
                $kodeBuku  = 'BUK-' . str_pad($seq, 4, '0', STR_PAD_LEFT);

                Perpustakaan::create([
                    'kode_buku'      => $kodeBuku,
                    'judul_buku'     => $judulBuku,
                    'pengarang'      => $pengarang ?: null,
                    'penulis'        => $pengarang ?: null,
                    'penerbit'       => $penerbit ?: null,
                    'tahun_terbit'   => $tahunTerbit ?: null,
                    'isbn'           => $isbn ?: null,
                    'kategori_buku'  => $kategori,
                    'jumlah_buku'    => $jumlahBuku,
                    'kondisi_buku'   => $kondisiBuku,
                    'sinopsis'       => $sinopsis ?: null,
                    'is_featured'    => false,
                ]);

                $this->inserted++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris {$lineNumber}: Gagal disimpan — " . $e->getMessage();
                $this->skipped++;
            }
        }
    }
}
