<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Donasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; }
        .header { background-color: #64748b; padding: 25px 30px; border-bottom: 3px solid #475569; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: middle; }
        .header-table img { height: 50px; display: block; }
        .header h1 { color: #ffffff; font-size: 20px; font-weight: 700; margin: 0; }
        .header p { color: #f8fafc; font-size: 13px; margin-top: 5px; margin-bottom: 0; font-weight: 400; }
        .content { padding: 35px 30px; }
        .greeting { font-size: 16px; margin-bottom: 15px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.6; color: #475569; margin-bottom: 20px; }
        .data-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 20px; margin: 20px 0; text-align: left; }
        .receipt-table { width: 100%; border-collapse: collapse; margin: 15px 0; text-align: left; }
        .receipt-table th, .receipt-table td { padding: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; }
        .receipt-table th { color: #64748b; font-weight: 500; width: 40%; }
        .receipt-table td { color: #1e293b; font-weight: 600; }
        .warning-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 16px; margin: 20px 0; border-radius: 0 8px 8px 0; }
        .warning-box p { font-size: 13px; color: #92400e; margin: 0; }
        .note-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 15px; margin: 15px 0; }
        .note-box p { color: #991b1b; font-style: italic; font-size: 14px; margin: 0; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 30px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.5; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <table class="header-table">
                <tr>
                    <td width="70">
                        <img src="{{ $message->embed(public_path('images/logo-panti-single.png')) }}" alt="Logo SIMPA">
                    </td>
                    <td>
                        <h1>Pemberitahuan Donasi</h1>
                        <p>Pemberitahuan Otomatis SIMPA</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Terima kasih atas niat baik Anda untuk berdonasi. Namun setelah tim kami melakukan 
                pengecekan, donasi berikut ini <strong>belum dapat kami verifikasi</strong>:
            </p>
            <div class="data-box">
                <table class="receipt-table">
                    <tr><th>Nominal Donasi</th><td>Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td></tr>
                    <tr><th>Status</th><td style="color: #dc2626;">Ditolak</td></tr>
                </table>
                <div style="font-size: 12px; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 15px;">Catatan Admin:</div>
                <div class="note-box">
                    <p>"{{ $data['catatan'] }}"</p>
                </div>
            </div>
            <div class="warning-box">
                <p>Jika ini adalah kesalahan (misal: bukti transfer buram/salah), Anda bisa mencoba mengunggah ulang form donasi di website kami.</p>
            </div>
        </div>
        <div class="footer">
            <p>Pesan ini merupakan pemberitahuan otomatis dari sistem SIMPA (Sistem Informasi Manajemen Panti Asuhan).</p>
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
