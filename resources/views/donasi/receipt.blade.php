<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Donasi #{{ str_pad($donasi->id_donasi, 6, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: white !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                margin: 0 !important;
                padding: 10mm !important;
            }
        }
        body {
            font-family: 'Times New Roman', Times, serif; /* Mengikuti gaya kwitansi klasik */
            background-color: #f8fafc;
            color: #000;
        }
        .dotted-cut {
            border-top: 2px dashed #000;
            position: relative;
            margin: 40px 0;
        }
        .dotted-cut::before {
            content: "✂";
            position: absolute;
            top: -12px;
            left: -20px;
            font-size: 20px;
            color: #000;
        }
        .dotted-cut::after {
            content: "✂";
            position: absolute;
            top: -12px;
            right: -20px;
            font-size: 20px;
            color: #000;
        }
        
        /* Helper variables for checkboxes */
        @php
            $isSembako = str_contains(strtolower($donasi->metode_pembayaran), 'sembako') || str_contains(strtolower($donasi->metode_pembayaran), 'barang');
            $isTransfer = in_array(strtolower($donasi->metode_pembayaran), ['transfer', 'qris', 'bjb', 'bri']);
            
            $nominalDisplay = '';
            if ($isSembako) {
                // If sembako, try to extract the item description from catatan
                $nominalDisplay = str_replace('Donasi Sembako: ', '', $donasi->catatan_verifikasi);
            } else {
                $nominalDisplay = 'Rp ' . number_format($donasi->nominal, 0, ',', '.');
            }
            
            $hp = $donasi->user->donatur->no_hp ?? $donasi->no_hp_donatur_manual ?? '';
            $alamat = $donasi->user->donatur->alamat ?? '';
        @endphp
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen py-8 bg-slate-100">
    
    <!-- Action Buttons -->
    <div class="w-full max-w-[210mm] flex justify-end gap-3 mb-4 no-print font-sans">
        @if(!request()->routeIs('donasi.receipt.public'))
        <a href="{{ route('donasi.index') }}" class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 rounded text-sm font-bold hover:bg-slate-100 transition-colors uppercase tracking-wider">
            &larr; Kembali
        </a>
        @else
        <a href="{{ url('/') }}" class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 rounded text-sm font-bold hover:bg-slate-100 transition-colors uppercase tracking-wider">
            &larr; Beranda
        </a>
        @endif
        <button onclick="window.print()" class="px-5 py-2.5 bg-slate-800 border-2 border-slate-800 text-white rounded text-sm font-bold hover:bg-slate-900 transition-colors flex items-center gap-2 uppercase tracking-wider shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak PDF
        </button>
    </div>

    <!-- A4 Container -->
    <div class="print-container bg-white shadow-xl max-w-[210mm] w-full mx-auto p-[10mm] overflow-hidden">
        
        <!-- ================= RECEIPT 1 (TOP) ================= -->
        <div class="receipt-block">
            <!-- Header -->
            <div class="flex items-center justify-between mb-2">
                <div class="w-24 shrink-0 flex justify-center">
                    <img src="{{ asset('images/logo-panti-single.png') }}" alt="Logo" class="h-20 w-auto object-contain grayscale">
                </div>
                <div class="text-center flex-grow px-4">
                    <h2 class="font-bold text-lg tracking-wide">YAYASAN PANTI ASUHAN</h2>
                    <h1 class="font-bold text-2xl tracking-wider mt-1">AMALIYA SUBANG</h1>
                    <p class="text-sm mt-1">Alamat : Blok Suka Asih, RT 23/RW 07, Kel. Karanganyar, Kec/Kab. Subang 41211</p>
                    <p class="text-sm">Telp: (0260) xxxxxx | email : info@amaliyasubang.org</p>
                </div>
                <div class="w-24 shrink-0"></div> <!-- Balancer -->
            </div>
            
            <!-- Double Line Separator -->
            <div class="border-b-[3px] border-black mb-[2px]"></div>
            <div class="border-b border-black mb-4"></div>
            
            <!-- Title -->
            <div class="text-center mb-4">
                <p class="italic text-md mb-2">Bismillahirrahmanirrahim,</p>
                <h3 class="font-bold text-lg underline inline-block">TANDA PENERIMAAN INFAQ DAN DONASI</h3>
            </div>
            
            <div class="text-justify leading-relaxed mb-4 text-base">
                Telah diterima infaq atau donasi untuk keperluan kegiatan <span class="inline-block border-b border-black w-48 text-center">{{ $donasi->catatan ?? 'Operasional Panti' }}</span> di Yayasan Amaliya Subang dari :
            </div>
            
            <!-- Form Grid -->
            <div class="pl-8 mb-6">
                <table class="w-full text-base border-separate border-spacing-y-2">
                    <tr>
                        <td class="w-32 align-bottom">Nama</td>
                        <td class="w-4 text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2 font-medium">{{ $donasi->nama_donatur_display }}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Alamat</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2">{!! $alamat ?: str_repeat('&nbsp;', 50) !!}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">No Telp/HP</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2">{!! $hp ?: str_repeat('&nbsp;', 30) !!}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Jenis Donasi</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="align-bottom pt-1">
                            <div class="flex gap-12">
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! $isSembako ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Barang/Sembako</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! !$isSembako ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Uang Tunai</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Nominal/Barang</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2 font-bold">{{ $nominalDisplay }}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Pembayaran</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="align-bottom pt-1">
                            <div class="flex gap-12">
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! !$isTransfer ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Tunai/Langsung</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! $isTransfer ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Transfer ke Rekening Yayasan</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Signatures -->
            <div class="flex justify-between mt-8 text-base">
                <div class="text-center w-56">
                    <p class="mb-20 opacity-0">Spacer</p>
                    <p class="font-bold border-b border-black pb-1 inline-block min-w-[150px]">{{ $donasi->nama_donatur_display }}</p>
                    <p class="mt-1">Donatur</p>
                </div>
                <div class="text-center w-56">
                    <p class="mb-4">Subang, {{ $donasi->tanggal_verifikasi ? $donasi->tanggal_verifikasi->locale('id_ID')->translatedFormat('d F Y') : now()->locale('id_ID')->translatedFormat('d F Y') }}</p>
                    <p class="mb-14">Bendahara Yayasan,</p>
                    <p class="font-bold border-b border-black pb-1 inline-block min-w-[150px]">{{ $donasi->bendahara->nama_lengkap ?? $donasi->bendahara->username ?? 'Pengurus' }}</p>
                </div>
            </div>
        </div>
        
        <!-- ================= DOTTED CUT LINE ================= -->
        <div class="dotted-cut"></div>

        <!-- ================= RECEIPT 2 (BOTTOM - EXACT COPY) ================= -->
        <div class="receipt-block">
            <!-- Header -->
            <div class="flex items-center justify-between mb-2">
                <div class="w-24 shrink-0 flex justify-center">
                    <img src="{{ asset('images/logo-panti-single.png') }}" alt="Logo" class="h-20 w-auto object-contain grayscale">
                </div>
                <div class="text-center flex-grow px-4">
                    <h2 class="font-bold text-lg tracking-wide">YAYASAN PANTI ASUHAN</h2>
                    <h1 class="font-bold text-2xl tracking-wider mt-1">AMALIYA SUBANG</h1>
                    <p class="text-sm mt-1">Alamat : Blok Suka Asih, RT 23/RW 07, Kel. Karanganyar, Kec/Kab. Subang 41211</p>
                    <p class="text-sm">Telp: (0260) xxxxxx | email : info@amaliyasubang.org</p>
                </div>
                <div class="w-24 shrink-0"></div> <!-- Balancer -->
            </div>
            
            <!-- Double Line Separator -->
            <div class="border-b-[3px] border-black mb-[2px]"></div>
            <div class="border-b border-black mb-4"></div>
            
            <!-- Title -->
            <div class="text-center mb-4">
                <p class="italic text-md mb-2">Bismillahirrahmanirrahim,</p>
                <h3 class="font-bold text-lg underline inline-block">TANDA PENERIMAAN INFAQ DAN DONASI</h3>
            </div>
            
            <div class="text-justify leading-relaxed mb-4 text-base">
                Telah diterima infaq atau donasi untuk keperluan kegiatan <span class="inline-block border-b border-black w-48 text-center">{{ $donasi->catatan ?? 'Operasional Panti' }}</span> di Yayasan Amaliya Subang dari :
            </div>
            
            <!-- Form Grid -->
            <div class="pl-8 mb-6">
                <table class="w-full text-base border-separate border-spacing-y-2">
                    <tr>
                        <td class="w-32 align-bottom">Nama</td>
                        <td class="w-4 text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2 font-medium">{{ $donasi->nama_donatur_display }}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Alamat</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2">{!! $alamat ?: str_repeat('&nbsp;', 50) !!}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">No Telp/HP</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2">{!! $hp ?: str_repeat('&nbsp;', 30) !!}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Jenis Donasi</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="align-bottom pt-1">
                            <div class="flex gap-12">
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! $isSembako ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Barang/Sembako</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! !$isSembako ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Uang Tunai</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Nominal/Barang</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="border-b border-black align-bottom pb-1 px-2 font-bold">{{ $nominalDisplay }}</td>
                    </tr>
                    <tr>
                        <td class="align-bottom">Pembayaran</td>
                        <td class="text-center align-bottom">:</td>
                        <td class="align-bottom pt-1">
                            <div class="flex gap-12">
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! !$isTransfer ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Tunai/Langsung</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <span class="text-xl leading-none mt-[-4px]">{!! $isTransfer ? '&#9745;' : '&#9744;' !!}</span>
                                    <span>Transfer ke Rekening Yayasan</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <!-- Signatures -->
            <div class="flex justify-between mt-8 text-base">
                <div class="text-center w-56">
                    <p class="mb-20 opacity-0">Spacer</p>
                    <p class="font-bold border-b border-black pb-1 inline-block min-w-[150px]">{{ $donasi->nama_donatur_display }}</p>
                    <p class="mt-1">Donatur</p>
                </div>
                <div class="text-center w-56">
                    <p class="mb-4">Subang, {{ $donasi->tanggal_verifikasi ? $donasi->tanggal_verifikasi->locale('id_ID')->translatedFormat('d F Y') : now()->locale('id_ID')->translatedFormat('d F Y') }}</p>
                    <p class="mb-14">Bendahara Yayasan,</p>
                    <p class="font-bold border-b border-black pb-1 inline-block min-w-[150px]">{{ $donasi->bendahara->nama_lengkap ?? $donasi->bendahara->username ?? 'Pengurus' }}</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
