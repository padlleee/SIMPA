<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan – Yayasan Amaliya Subang</title>
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
        .summary-table td.val-expense { color: #991b1b; }
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

        .trx-table tfoot tr { border-top: 1.5px solid #111; border-bottom: 1.5px solid #111; }
        .trx-table tfoot td {
            padding: 7px 8px;
            font-weight: bold;
            font-size: 9.5pt;
            text-align: right;
        }
        .trx-table tfoot td:first-child { text-align: left; }

        /* ===== TANDA TANGAN ===== */
        .ttd-section { margin-top: 36px; display: flex; justify-content: flex-end; }
        .ttd-box { text-align: center; width: 210px; font-size: 10pt; }
        .ttd-box .ttd-space { height: 58px; }
        .ttd-box .ttd-line  { border-top: 1px solid #111; padding-top: 4px; font-weight: bold; }

        /* ===== FOOTER ===== */
        .page-footer {
            margin-top: 28px;
            border-top: 1px solid #bbb;
            padding-top: 7px;
            font-size: 8pt;
            color: #888;
            display: flex;
            justify-content: space-between;
        }

        /* ===== PRINT ===== */
        @media print {
            body { background: #fff; padding: 0; }
            .action-bar { display: none !important; }
            .paper { box-shadow: none; padding: 0; width: 100%; margin: 0; min-height: auto; }
            table { page-break-inside: auto; }
            tr    { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        @page { size: A4 portrait; margin: 1.8cm 2cm; }
    </style>
</head>
<body>

{{-- TOOLBAR --}}
<div class="action-bar">
    <span class="label">Pratinjau Laporan — siap dicetak sebagai dokumen resmi</span>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('laporan.index', request()->query()) }}" class="btn btn-back">← Kembali</a>
        <button onclick="window.print()" class="btn btn-print">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak / Simpan PDF
        </button>
    </div>
</div>

{{-- KERTAS A4 --}}
<div class="paper">

    {{-- KOP SURAT --}}
    <div class="kop">
        <img src="{{ asset('images/logo-panti-single.png') }}" alt="Logo">
        <div class="kop-text">
            <div class="org-name">YAYASAN AMALIYA SUBANG</div>
            <div class="org-sub">Panti Asuhan Amaliya — Lembaga Sosial Kemanusiaan</div>
            <div class="org-addr">Asrama Panti Asuhan Amaliya, Subang, Jawa Barat &nbsp;·&nbsp; SIMPA – Sistem Informasi Manajemen Panti Asuhan</div>
        </div>
    </div>

    {{-- JUDUL --}}
    <div class="report-title">
        <h1>Laporan Keuangan</h1>
        <p>Rekapitulasi Pemasukan dan Pengeluaran &mdash; Yayasan Amaliya Subang</p>
    </div>
    <hr class="divider">

    {{-- META INFO --}}
    <table class="meta-table">
        <tr>
            <td>Tanggal Cetak</td><td>:</td>
            <td>{{ now()->locale('id')->translatedFormat('j F Y, H:i') }} WIB</td>
            <td style="width:40px;"></td>
            <td style="color:#555; width:110px;">Dicetak Oleh</td><td>:</td>
            <td style="font-weight:600;">{{ auth()->user()->username }} ({{ auth()->user()->role }})</td>
        </tr>
        <tr>
            <td>Periode</td><td>:</td>
            <td colspan="4">
                {{ request('dari_tanggal') ? \Carbon\Carbon::parse(request('dari_tanggal'))->locale('id')->translatedFormat('j F Y') : 'Semua waktu' }}
                &mdash;
                {{ request('sampai_tanggal') ? \Carbon\Carbon::parse(request('sampai_tanggal'))->locale('id')->translatedFormat('j F Y') : 'Semua waktu' }}
            </td>
        </tr>
        <tr>
            <td>Jumlah Transaksi</td><td>:</td>
            <td colspan="4">{{ $transaksi->count() }} transaksi</td>
        </tr>
    </table>

    {{-- RINGKASAN KEUANGAN --}}
    <div class="sec-title">Ringkasan Keuangan</div>
    <table class="summary-table">
        <tr>
            <td class="label-col">Total Pemasukan (Donasi)</td>
            <td class="sep-col">:</td>
            <td class="val-col val-income">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label-col">Total Pengeluaran</td>
            <td class="sep-col">:</td>
            <td class="val-col val-expense">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
        </tr>
        <tr class="saldo-row">
            <td class="label-col">Saldo Bersih</td>
            <td class="sep-col">:</td>
            <td class="val-col">Rp {{ number_format($saldoBersih, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- TABEL DETAIL --}}
    <div class="sec-title">Rincian Transaksi</div>
    @if($transaksi->count())
    <table class="trx-table">
        <thead>
            <tr>
                <th class="c" style="width:28px;">No.</th>
                <th style="width:84px;">Tanggal</th>
                <th>Keterangan</th>
                <th class="r" style="width:120px;">Pemasukan</th>
                <th class="r" style="width:120px;">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $i => $item)
            <tr>
                <td class="c num">{{ $i + 1 }}</td>
                <td>{{ optional($item['tanggal'])->translatedFormat('j M Y') ?? '-' }}</td>
                <td>{{ $item['keterangan'] }}</td>
                <td class="r">
                    @if($item['pemasukan'])
                        Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}
                    @else
                        <span style="color:#bbb;">—</span>
                    @endif
                </td>
                <td class="r">
                    @if($item['pengeluaran'])
                        Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}
                    @else
                        <span style="color:#bbb;">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Jumlah</td>
                <td>Rp {{ number_format($totalDonasi, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    @else
    <p style="text-align:center; color:#888; padding: 24px 0;">Tidak ada transaksi untuk periode yang dipilih.</p>
    @endif

    {{-- TANDA TANGAN --}}
    <div class="ttd-section">
        <div class="ttd-box">
            <div>Subang, {{ now()->locale('id')->translatedFormat('j F Y') }}</div>
            <div style="margin-top:4px;">Ketua Yayasan Amaliya</div>
            <div class="ttd-space"></div>
            <div class="ttd-line">( __________________________ )</div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="page-footer">
        <span>SIMPA – Sistem Informasi Manajemen Panti Asuhan Amaliya Subang</span>
        <span>Dicetak: {{ now()->format('d/m/Y H:i') }} WIB</span>
    </div>

</div>

<script>
    window.addEventListener('load', () => window.print());
</script>
</body>
</html>
