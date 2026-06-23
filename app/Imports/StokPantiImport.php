<?php

namespace App\Imports;

use App\Models\StokPanti;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class StokPantiImport
{
    public int $inserted = 0;
    public int $skipped  = 0;
    public array $errors = [];

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

                $kategori  = trim((string)($row[1] ?? '')) ?: 'Umum';
                $merk      = trim((string)($row[2] ?? ''));
                $stokAwal  = max(0, (int)($row[3] ?? 0));
                $satuan    = trim((string)($row[4] ?? 'Pcs')) ?: 'Pcs';

                // Parse tanggal kadaluarsa (opsional)
                $tglKadRaw = $row[5] ?? null;
                $tglKad    = null;
                if (!empty(trim((string)$tglKadRaw))) {
                    $tglKad = $this->parseDate($tglKadRaw);
                }

                $keterangan  = trim((string)($row[6] ?? ''));
                $kodeBarang  = StokPanti::generateKodeBarang();

                // Stok akhir = stok awal (saat import belum ada transaksi)
                StokPanti::create([
                    'nama_barang'         => $namaBarang,
                    'kategori_barang'     => $kategori,
                    'merk'                => $merk ?: null,
                    'kode_barang'         => $kodeBarang,
                    'stok_awal'           => $stokAwal,
                    'barang_masuk'        => 0,
                    'barang_keluar'       => 0,
                    'stok_akhir'          => $stokAwal,
                    'satuan'              => $satuan,
                    'tanggal_kadaluarsa'  => $tglKad,
                    'keterangan'          => $keterangan ?: null,
                    'id_admin'            => auth()->id(),
                ]);

                $this->inserted++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris {$lineNumber}: Gagal disimpan — " . $e->getMessage();
                $this->skipped++;
            }
        }
    }

    private function parseDate($value): ?string
    {
        if (is_numeric($value)) {
            try {
                $date = ExcelDate::excelToDateTimeObject((float)$value);
                return $date->format('Y-m-d');
            } catch (\Throwable) {}
        }

        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'd/m/y'];
        foreach ($formats as $fmt) {
            try {
                return Carbon::createFromFormat($fmt, trim((string)$value))->format('Y-m-d');
            } catch (\Throwable) {}
        }

        return null;
    }
}
