<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Donasi #{{ $donasi->id_donasi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }
            .no-print {
                display: none;
            }
            .container {
                max-width: 100%;
                margin: 0;
                padding: 40px;
            }
        }

        /* Header */
        .header {
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .organization-info h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .organization-info p {
            font-size: 13px;
            color: #666;
        }

        .receipt-title {
            text-align: right;
        }

        .receipt-title h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .receipt-number {
            font-size: 14px;
            color: #666;
        }

        /* Content */
        .content {
            margin-bottom: 30px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            margin-bottom: 15px;
            color: #000;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .info-label {
            font-weight: 500;
            color: #333;
            min-width: 200px;
        }

        .info-value {
            text-align: right;
            color: #333;
        }

        /* Donation Amount */
        .amount-section {
            background: #f9f9f9;
            padding: 20px;
            border: 2px solid #000;
            margin: 25px 0;
            text-align: center;
        }

        .amount-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .amount-value {
            font-size: 32px;
            font-weight: bold;
            color: #000;
        }

        /* Signature Area */
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 10px;
            font-size: 13px;
            font-weight: 500;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        /* Buttons */
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        button, .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print {
            background: #000;
            color: white;
        }

        .btn-print:hover {
            background: #333;
        }

        .btn-back {
            background: #e0e0e0;
            color: #000;
        }

        .btn-back:hover {
            background: #ccc;
        }

        /* Badge */
        .verified-badge {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }

        /* Notes */
        .notes {
            background: #f0f0f0;
            padding: 15px;
            border-left: 4px solid #000;
            margin-top: 25px;
            font-size: 13px;
            line-height: 1.5;
        }

        .notes p {
            margin-bottom: 8px;
        }

        .notes p:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="organization-info">
                    <h1>🏛️ YAYASAN PANTI ASUHAN</h1>
                    <p>Jl. Contoh No. 123, Kota Bandung, Jawa Barat 40000</p>
                    <p>Telepon: (0274) 123-456 | Email: info@pantasuhan.org</p>
                    <p>No. NPWP: 12.345.678.9-000.000</p>
                </div>
                <div class="receipt-title">
                    <h2>KWITANSI</h2>
                    <div class="receipt-number">
                        <p>No. <strong>#{{ str_pad($donasi->id_donasi, 6, '0', STR_PAD_LEFT) }}</strong></p>
                        <p>Tanggal: {{ now()->locale('id_ID')->translatedFormat('j F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Donor Information -->
            <div class="section">
                <div class="section-title">Data Donatur</div>
                <div class="info-row">
                    <span class="info-label">Nama Donatur</span>
                    <span class="info-value">{{ $donasi->nama_donatur_display }}</span>
                </div>
                @if($donasi->donatur && $donasi->donatur->email)
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $donasi->donatur->email }}</span>
                </div>
                @endif
                @if($donasi->donatur && $donasi->donatur->no_hp)
                <div class="info-row">
                    <span class="info-label">Nomor Telepon</span>
                    <span class="info-value">{{ $donasi->donatur->no_hp }}</span>
                </div>
                @endif
            </div>

            <!-- Donation Information -->
            <div class="section">
                <div class="section-title">Informasi Donasi</div>
                <div class="info-row">
                    <span class="info-label">Nominal Donasi</span>
                    <span class="info-value">{{ $donasi->nominal_formatted }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Metode Pembayaran</span>
                    <span class="info-value">{{ $donasi->metode_pembayaran }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Donasi</span>
                    <span class="info-value">{{ $donasi->tanggal_donasi->locale('id_ID')->translatedFormat('j F Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Verifikasi</span>
                    <span class="info-value">{{ $donasi->tanggal_verifikasi->locale('id_ID')->translatedFormat('j F Y H:i') }}</span>
                </div>
            </div>

            <!-- Donation Amount (Highlighted) -->
            <div class="amount-section">
                <div class="amount-label">JUMLAH DONASI</div>
                <div class="amount-value">{{ $donasi->nominal_formatted }}</div>
                <div class="verified-badge">✓ SUDAH TERVERIFIKASI</div>
            </div>

            <!-- Bank Information -->
            <div class="section">
                <div class="section-title">Bank Penerima</div>
                <div class="info-row">
                    <span class="info-label">Bank BRI</span>
                    <span class="info-value">1234567890 a.n. YAYASAN PANTI ASUHAN</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Bank BJB</span>
                    <span class="info-value">0987654321 a.n. YAYASAN PANTI ASUHAN</span>
                </div>
            </div>

            <!-- Verification Info -->
            <div class="section">
                <div class="section-title">Diverifikasi Oleh</div>
                <div class="info-row">
                    <span class="info-label">Nama Bendahara</span>
                    <span class="info-value">{{ $donasi->bendahara->nama_lengkap ?? $donasi->bendahara->username ?? 'Admin' }}</span>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p style="font-size: 13px; margin-bottom: 50px;">Donatur</p>
                <div class="signature-line">{{ $donasi->nama_donatur_display }}</div>
            </div>
            <div class="signature-box">
                <p style="font-size: 13px; margin-bottom: 50px;">Bendahara Yayasan</p>
                <div class="signature-line">{{ $donasi->bendahara->nama_lengkap ?? $donasi->bendahara->username ?? 'Admin' }}</div>
            </div>
        </div>

        <!-- Notes -->
        <div class="notes">
            <p><strong>Catatan Penting:</strong></p>
            <p>✓ Kwitansi ini merupakan bukti sah bahwa donasi Anda telah diterima dan diverifikasi oleh Yayasan Panti Asuhan.</p>
            <p>✓ Untuk keperluan administrasi atau perpajakan, silakan simpan kwitansi ini dengan baik.</p>
            <p>✓ Hubungi kami jika ada pertanyaan atau klarifikasi mengenai donasi Anda.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini dicetak secara otomatis oleh sistem SIMPA (Sistem Informasi Manajemen Panti Asuhan)</p>
            <p>Dicetak pada: {{ now()->locale('id_ID')->translatedFormat('j F Y H:i:s') }}</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons no-print">
            <button class="btn btn-print" onclick="window.print()">
                🖨️ Cetak / Simpan sebagai PDF
            </button>
            <a href="{{ route('donasi.index') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>
    </div>

    <script>
        // Auto-format currency for display (already done in PHP, but for reference)
        document.addEventListener('DOMContentLoaded', function() {
            // Print styling for better PDF generation
            if (window.location.hash === '#print') {
                window.print();
            }
        });
    </script>
</body>
</html>
