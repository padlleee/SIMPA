<?php

namespace App\Imports;

use App\Models\InventarisPeralatan;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InventarisImport
{
    public int $inserted = 0;
    public int $skipped  = 0;
    public array $errors = [];

    private array $validKondisi  = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
    private array $validRuangan  = [
        'Kantor', 'Asrama', 'Dapur', 'Aula',
        'Perpustakaan', 'Ruang Belajar', 'Gudang', 'Lainnya',
    ];

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, false);

        foreach (array_slice($rows, 1) as $rowIndex => $row) {
            $lineNumber = $rowIndex + 2;

            if (empty(trim((string)($row[0] ?? '')))) continue;

            try {
                $namaBarang = trim((string)($row[0] ?? ''));
                if (empty($namaBarang)) {
                    $this->errors[] = "Baris {$lineNumber}: Nama barang wajib diisi.";
                    $this->skipped++;
                    continue;
                }

                $namaKategori = trim((string)($row[1] ?? ''));
                if (empty($namaKategori)) {
                    $this->errors[] = "Baris {$lineNumber}: Nama kategori wajib diisi.";
                    $this->skipped++;
                    continue;
                }

                $jumlah = (int)($row[2] ?? 1);
                if ($jumlah <= 0) $jumlah = 1;

                $satuan    = trim((string)($row[3] ?? 'Unit')) ?: 'Unit';
                $kondisi   = trim((string)($row[4] ?? 'Baik'));
                if (!in_array($kondisi, $this->validKondisi)) $kondisi = 'Baik';

                $ruangan = trim((string)($row[5] ?? 'Lainnya'));
                if (!in_array($ruangan, $this->validRuangan)) $ruangan = 'Lainnya';

                $lokasi     = trim((string)($row[6] ?? ''));
                $keterangan = trim((string)($row[7] ?? ''));
                $kodeBarang = trim((string)($row[8] ?? ''));

                InventarisPeralatan::create([
                    'nama_barang'   => $namaBarang,
                    'nama_kategori' => $namaKategori,
                    'jumlah'        => $jumlah,
                    'satuan'        => $satuan,
                    'kondisi'       => $kondisi,
                    'ruangan'       => $ruangan,
                    'lokasi'        => $lokasi ?: null,
                    'keterangan'    => $keterangan ?: null,
                    'kode_barang'   => $kodeBarang ?: null,
                ]);

                $this->inserted++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris {$lineNumber}: Gagal disimpan — " . $e->getMessage();
                $this->skipped++;
            }
        }
    }
}
