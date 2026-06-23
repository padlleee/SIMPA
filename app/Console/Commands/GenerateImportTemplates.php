<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class GenerateImportTemplates extends Command
{
    protected $signature   = 'import:generate-templates';
    protected $description = 'Generate template Excel untuk fitur Import (Anak Asuh, Inventaris, Stok, Perpustakaan)';

    public function handle(): void
    {
        $dir = public_path('templates');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $this->generateAnakAsuh($dir);
        $this->generateInventaris($dir);
        $this->generateStokPanti($dir);
        $this->generatePerpustakaan($dir);

        $this->info('Semua template berhasil dibuat di public/templates/');
    }

    // ─────────────────────────────────────────────────────────────
    private function generateAnakAsuh(string $dir): void
    {
        $headers = [
            'Nama Anak *', 'Tanggal Lahir * (DD/MM/YYYY)', 'Jenis Kelamin * (L/P)',
            'Pendidikan', 'Tanggal Masuk (DD/MM/YYYY)', 'Status (Aktif/Alumni)',
            'Tempat Lahir', 'Kelas', 'Jenis Layanan (Mukim/Non Mukim)',
            'Dusun', 'Desa', 'Kecamatan',
        ];
        $sample = [
            'Ahmad Farid', '12/03/2015', 'L',
            'SD', '01/01/2023', 'Aktif',
            'Subang', 'Kelas 3', 'Mukim',
            'Cibogo', 'Cibogo', 'Cibogo',
        ];

        $this->buildSheet('Data Anak Asuh', $headers, $sample, $dir . '/template_anak_asuh.xlsx');
        $this->info('✓ template_anak_asuh.xlsx');
    }

    private function generateInventaris(string $dir): void
    {
        $headers = [
            'Nama Barang *', 'Nama Kategori *', 'Jumlah', 'Satuan',
            'Kondisi (Baik/Rusak Ringan/Rusak Berat)', 'Ruangan',
            'Lokasi Detail', 'Keterangan', 'Kode Barang',
        ];
        $sample = [
            'Meja Belajar', 'Meja', 10, 'Unit',
            'Baik', 'Ruang Belajar',
            'Lantai 1 Timur', 'Kondisi prima', 'DESK-001',
        ];

        $this->buildSheet('Data Inventaris', $headers, $sample, $dir . '/template_inventaris.xlsx');
        $this->info('✓ template_inventaris.xlsx');
    }

    private function generateStokPanti(string $dir): void
    {
        $headers = [
            'Nama Barang *', 'Kategori Barang', 'Merk/Brand',
            'Stok Awal', 'Satuan', 'Tanggal Kadaluarsa (DD/MM/YYYY)', 'Keterangan',
        ];
        $sample = [
            'Beras', 'Bahan Pangan', 'Cap Ayam',
            50, 'Kg', '31/12/2025', 'Stok utama dapur',
        ];

        $this->buildSheet('Data Stok Panti', $headers, $sample, $dir . '/template_stok_panti.xlsx');
        $this->info('✓ template_stok_panti.xlsx');
    }

    private function generatePerpustakaan(string $dir): void
    {
        $headers = [
            'Judul Buku *', 'Pengarang', 'Penerbit', 'Tahun Terbit',
            'ISBN', 'Kategori', 'Jumlah Buku', 'Kondisi (Baik/Cukup/Rusak)', 'Sinopsis',
        ];
        $sample = [
            'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005,
            '978-979-1079-00-7', 'Novel', 3, 'Baik', 'Kisah perjuangan anak-anak di Belitung.',
        ];

        $this->buildSheet('Data Perpustakaan', $headers, $sample, $dir . '/template_perpustakaan.xlsx');
        $this->info('✓ template_perpustakaan.xlsx');
    }

    // ─────────────────────────────────────────────────────────────
    private function buildSheet(string $title, array $headers, array $sampleRow, string $path): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle($title);

        $colCount = count($headers);
        $lastCol  = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // Header row
        foreach ($headers as $i => $header) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col . '1', $header);
        }

        // Header style
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CBD5E1'],
                ],
            ],
        ];
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Sample row
        foreach ($sampleRow as $i => $value) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col . '2', $value);
        }

        // Sample row style
        $sampleStyle = [
            'font' => ['color' => ['rgb' => '64748B'], 'italic' => true],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F8FAFC'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'E2E8F0'],
                ],
            ],
        ];
        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray($sampleStyle);

        // Data area borders for rows 3-101
        $sheet->getStyle("A3:{$lastCol}101")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_HAIR,
                    'color'       => ['rgb' => 'E2E8F0'],
                ],
            ],
        ]);

        // Auto-width columns
        for ($i = 1; $i <= $colCount; $i++) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Freeze header row
        $sheet->freezePane('A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
    }
}
