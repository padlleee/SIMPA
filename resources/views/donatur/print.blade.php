<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Donasi – {{ $user->donatur->nama_donatur ?? $user->username }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #111;
            background: #e8e8e8;
            padding: 24px;
        }

        /* ===== TOOLBAR (tidak ikut cetak) ===== */
        .action-bar {
            width: 21cm;
            margin: 0 auto 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: sans-serif;
        }
        .action-bar .label { font-size: 9.5pt; color: #555; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 10pt;
            font-family: sans-serif;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-print { background: #111; color: #fff; }
        .btn-back  { background: #ddd; color: #333; }

        /* ===== KERTAS A4 ===== */
        .paper {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            background: #fff;
            padding: 2cm 2.2cm;
            box-shadow: 0 4px 28px rgba(0,0,0,0.15);
        }

        /* ===== KOP SURAT ===== */
        .kop {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-bottom: 12px;
            border-bottom: 3px double #111;
        }
        .kop img { width: 64px; height: 64px; object-fit: contain; flex-shrink: 0; }
        .kop-text .org-name { font-size: 16pt; font-weight: bold; letter-spacing: 0.5px; }
        .kop-text .org-sub  { font-size: 10pt; color: #444; margin-top: 2px; }
        .kop-text .org-addr { font-size: 8.5pt; color: #666; margin-top: 3px; }

        /* ===== JUDUL ===== */
        .report-title {
            text-align: center;
            margin: 14px 0 4px;
        }
        .report-title h1 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .report-title p { font-size: 9.5pt; color: #555; margin-top: 3px; }
        .divider { border: none; border-top: 1.5px solid #111; margin: 10px 0 16px; }

        /* ===== TABEL META ===== */
        .meta-table { width: 100%; border-collapse: collapse; font-size: 9.5pt; margin-bottom: 18px; }
        .meta-table td { padding: 2.5px 6px; }
        .meta-table td:first-child { color: #555; width: 120px; }
        .meta-table td:nth-child(2) { width: 8px; color: #888; }
        .meta-table td:nth-child(3) { font-weight: 600; }

        /* ===== SECTION TITLE ===== */
        .sec-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-bottom: 1.5px solid #111;
            padding-bottom: 4px;
            margin-bottom: 10px;
            margin-top: 18px;
        }

        /* ===== RINGKASAN (tabel sederhana) ===== */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
            margin-bottom: 4px;
        }
        .summary-table td { padding: 5px 8px; }
        .summary-table tr:not(:last-child) td { border-bottom: 1px solid #e0e0e0; }
        .summary-table td.label-col { color: #444; }
        .summary-table td.sep-col   { width: 14px; color: #888; }
        .summary-table td.val-col   { text-align: right; font-weight: 700; font-size: 10.5pt; }
        .summary-table td.val-income  { color: #166534; }
        .summary-table tr.saldo-row td {
            border-top: 2px solid #111;
            padding-top: 7px;
            font-weight: bold;
            font-size: 11pt;
        }

        /* ===== TABEL DETAIL ===== */
        .trx-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .trx-table thead tr {
            border-top: 1.5px solid #111;
            border-bottom: 1.5px solid #111;
        }
        .trx-table thead th {
            padding: 7px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            background: transparent;
        }
        .trx-table thead th.r { text-align: right; }
        .trx-table thead th.c { text-align: center; }

        .trx-table tbody tr { border-bottom: 1px solid #ddd; }
        .trx-table tbody tr:last-child { border-bottom: none; }
        .trx-table tbody td {
            padding: 6px 8px;
            vertical-align: top;
        }
        .trx-table tbody td.r  { text-align: right; }
        .trx-table tbody td.c  { text-align: center; }
        .trx-table tbody td.num { color: #888; font-size: 8.5pt; }

        /* ===== TANDA TANGAN ===== */
        .ttd-container {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        .ttd-box {
            width: 200px;
            text-align: center;
            font-size: 9.5pt;
        }
        .ttd-box .date { margin-bottom: 60px; }
        .ttd-box .name { font-weight: bold; text-decoration: underline; }
        .ttd-box .role { margin-top: 3px; color: #444; }

        /* ===== PRINT SPECIFIC CSS ===== */
        @media print {
            body { background: transparent; padding: 0; }
            .action-bar { display: none !important; }
            .paper { box-shadow: none; padding: 0; width: 100%; min-height: auto; }
            @page { size: A4; margin: 1.5cm 2cm; }
        }
    </style>
</head>
<body>

    <!-- TOOLBAR (Hanya di layar) -->
    <div class="action-bar">
        <span class="label">Pratinjau Cetak: Gunakan kertas A4.</span>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('donatur.laporan') }}" class="btn btn-back">Kembali</a>
            <button onclick="window.print()" class="btn btn-print">Cetak Laporan</button>
        </div>
    </div>

    <!-- KERTAS A4 -->
    <div class="paper">
        
        <!-- KOP SURAT -->
        <div class="kop">
            <img src="{{ asset('images/logo-panti-single.png') }}" alt="Logo Panti">
            <div class="kop-text">
                <div class="org-name">YAYASAN PANTI ASUHAN AMALIYA</div>
                <div class="org-sub">Sistem Informasi Manajemen Panti Asuhan (SIMPA)</div>
                <div class="org-addr">Jl. Cagak, Subang, Jawa Barat | Telepon: 0812-xxxx-xxxx</div>
            </div>
        </div>

        <!-- JUDUL -->
        <div class="report-title">
            <h1>Laporan Riwayat Donasi</h1>
            <p>
                Periode: 
                @if($request->dari_tanggal && $request->sampai_tanggal)
                    {{ \Carbon\Carbon::parse($request->dari_tanggal)->translatedFormat('d F Y') }} s.d. 
                    {{ \Carbon\Carbon::parse($request->sampai_tanggal)->translatedFormat('d F Y') }}
                @else
                    Keseluruhan (Sejak awal hingga {{ now()->translatedFormat('d F Y') }})
                @endif
            </p>
        </div>

        <hr class="divider">

        <!-- META DONATUR -->
        <table class="meta-table">
            <tr>
                <td>Dicetak Oleh</td>
                <td>:</td>
                <td>{{ $user->donatur->nama_donatur ?? $user->username }} (ID: D-{{ str_pad($user->id_user, 4, '0', STR_PAD_LEFT) }})</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y H:i') }}</td>
            </tr>
            <tr>
                <td>Jumlah Transaksi</td>
                <td>:</td>
                <td>{{ $allDonations->count() }} Transaksi Sukses</td>
            </tr>
        </table>

        <!-- RINGKASAN SALDO -->
        <div class="sec-title">Ringkasan Total Donasi</div>
        <table class="summary-table" style="margin-bottom: 24px;">
            <tr>
                <td class="label-col">Total Seluruh Donasi (Terverifikasi)</td>
                <td class="sep-col">=</td>
                <td class="val-col val-income">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- TABEL DETAIL -->
        <div class="sec-title">Detail Riwayat Donasi</div>
        <table class="trx-table">
            <thead>
                <tr>
                    <th class="c" width="5%">No.</th>
                    <th width="20%">Tanggal Donasi</th>
                    <th width="30%">ID Referensi</th>
                    <th width="25%">Metode Bayar</th>
                    <th class="r" width="20%">Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allDonations as $index => $trx)
                <tr>
                    <td class="c num">{{ $index + 1 }}</td>
                    <td>{{ $trx->tanggal_donasi->translatedFormat('d M Y') }}</td>
                    <td>#{{ $trx->id_donasi }}</td>
                    <td>{{ $trx->metode_pembayaran }}</td>
                    <td class="r" style="color: #166534; font-weight: 500;">
                        {{ number_format($trx->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="c" style="padding: 20px 0; color:#888;">Tidak ada riwayat donasi pada periode ini.</td>
                </tr>
                @endforelse
                
                @if($allDonations->count() > 0)
                <tr>
                    <td colspan="4" class="r" style="font-weight: bold; padding-top: 10px; border-top: 1.5px solid #111;">TOTAL DONASI</td>
                    <td class="r" style="font-weight: bold; padding-top: 10px; border-top: 1.5px solid #111; color: #166534;">
                        Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- TANDA TANGAN -->
        <div class="ttd-container">
            <div class="ttd-box">
                <div class="date">Subang, {{ now()->translatedFormat('d F Y') }}</div>
                <div class="name">{{ $user->donatur->nama_donatur ?? $user->username }}</div>
                <div class="role">Donatur</div>
            </div>
        </div>

    </div>

    <!-- Script auto-print jika diperlukan (opsional, tapi saya hilangkan agar user bisa preview dulu) -->
    <!-- <script>window.onload = () => window.print();</script> -->
</body>
</html>
