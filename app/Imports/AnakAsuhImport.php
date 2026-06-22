<?php

namespace App\Imports;

use App\Models\AnakAsuh;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class AnakAsuhImport
{
    public int $inserted = 0;
    public int $skipped  = 0;
    public array $errors = [];

    private array $validPendidikan = ['TK', 'SD', 'SMP', 'SMA', 'SMK', 'Perguruan Tinggi', 'Tidak Sekolah', 'Lainnya'];
    private array $validLayanan    = ['Mukim', 'Non Mukim'];

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray(null, true, true, false);

        // Lewati baris header (baris pertama)
        foreach (array_slice($rows, 1) as $rowIndex => $row) {
            $lineNumber = $rowIndex + 2; // +2 karena header di baris 1

            // Lewati baris kosong
            if (empty(trim((string)($row[0] ?? '')))) {
                continue;
            }

            try {
                $namaAnak = trim((string)($row[0] ?? ''));
                if (empty($namaAnak)) {
                    $this->errors[] = "Baris {$lineNumber}: Nama anak wajib diisi.";
                    $this->skipped++;
                    continue;
                }

                // Parse tanggal lahir — support DD/MM/YYYY, YYYY-MM-DD, Excel serial
                $tglLahirRaw = $row[1] ?? null;
                $tglLahir    = $this->parseDate($tglLahirRaw, $lineNumber, 'Tanggal Lahir');
                if ($tglLahir === false) {
                    $this->skipped++;
                    continue;
                }

                // Jenis Kelamin: L / P / Laki-laki / Perempuan
                $jk = strtoupper(trim((string)($row[2] ?? '')));
                if (in_array($jk, ['L', 'LAKI-LAKI', 'LAKI'])) {
                    $jk = 'L';
                } elseif (in_array($jk, ['P', 'PEREMPUAN'])) {
                    $jk = 'P';
                } else {
                    $this->errors[] = "Baris {$lineNumber}: Jenis kelamin tidak valid (isi L atau P).";
                    $this->skipped++;
                    continue;
                }

                // Pendidikan — opsional
                $pendidikan = trim((string)($row[3] ?? ''));
                if (!empty($pendidikan) && !in_array($pendidikan, $this->validPendidikan)) {
                    $pendidikan = 'Lainnya'; // fallback jika tidak dikenali
                }

                // Parse tanggal masuk — opsional
                $tglMasukRaw = $row[4] ?? null;
                $tglMasuk    = null;
                if (!empty(trim((string)$tglMasukRaw))) {
                    $tglMasuk = $this->parseDate($tglMasukRaw, $lineNumber, 'Tanggal Masuk');
                    if ($tglMasuk === false) {
                        $tglMasuk = null; // jika gagal parse, isi null saja
                    }
                }

                $statusAnak   = ucfirst(strtolower(trim((string)($row[5] ?? 'Aktif'))));
                if (!in_array($statusAnak, ['Aktif', 'Alumni'])) $statusAnak = 'Aktif';

                $tempatLahir  = trim((string)($row[6] ?? ''));
                $kelas        = trim((string)($row[7] ?? ''));
                $jenisLayanan = trim((string)($row[8] ?? ''));
                if (!in_array($jenisLayanan, $this->validLayanan)) $jenisLayanan = null;
                $dusun        = trim((string)($row[9] ?? ''));
                $desa         = trim((string)($row[10] ?? ''));
                $kecamatan    = trim((string)($row[11] ?? ''));

                AnakAsuh::create([
                    'nama_anak'     => $namaAnak,
                    'tanggal_lahir' => $tglLahir,
                    'jenis_kelamin' => $jk,
                    'pendidikan'    => $pendidikan ?: null,
                    'tanggal_masuk' => $tglMasuk,
                    'status_anak'   => $statusAnak,
                    'tempat_lahir'  => $tempatLahir ?: null,
                    'kelas'         => $kelas ?: null,
                    'jenis_layanan' => $jenisLayanan,
                    'dusun'         => $dusun ?: null,
                    'desa'          => $desa ?: null,
                    'kecamatan'     => $kecamatan ?: null,
                ]);

                $this->inserted++;
            } catch (\Throwable $e) {
                $this->errors[] = "Baris {$lineNumber}: Gagal disimpan — " . $e->getMessage();
                $this->skipped++;
            }
        }
    }

    /**
     * Parse berbagai format tanggal ke string Y-m-d atau false jika gagal.
     */
    private function parseDate($value, int $line, string $field): string|bool|null
    {
        if (empty(trim((string)$value))) return null;

        // Excel numeric serial date
        if (is_numeric($value)) {
            try {
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$value);
                return $date->format('Y-m-d');
            } catch (\Throwable) {}
        }

        $formats = ['d/m/Y', 'Y-m-d', 'd-m-Y', 'd/m/y', 'Y/m/d'];
        foreach ($formats as $fmt) {
            try {
                $d = Carbon::createFromFormat($fmt, trim((string)$value));
                if ($d) return $d->format('Y-m-d');
            } catch (\Throwable) {}
        }

        $this->errors[] = "Baris {$line}: Format {$field} tidak dikenali ({$value}). Gunakan DD/MM/YYYY.";
        return false;
    }
}
