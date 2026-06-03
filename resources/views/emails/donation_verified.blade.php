<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Anda Telah Diverifikasi</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #065f46 0%, #16a34a 100%); padding: 30px 40px; text-align: center; }
        .header img { height: 60px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; }
        .header p { color: #bbf7d0; font-size: 13px; margin-top: 4px; }
        .content { padding: 36px 40px; }
        .greeting { font-size: 16px; margin-bottom: 14px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 20px; }
        .receipt-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 22px 26px; margin: 20px 0; }
        .receipt-box h3 { color: #166534; font-size: 15px; font-weight: 700; margin-bottom: 16px; border-bottom: 1px solid #bbf7d0; padding-bottom: 12px; }
        .receipt-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #dcfce7; }
        .receipt-row:last-child { border-bottom: none; }
        .receipt-label { font-size: 13px; color: #64748b; font-weight: 500; }
        .receipt-value { font-size: 13px; color: #1e293b; font-weight: 600; }
        .receipt-value.highlight { font-size: 18px; color: #15803d; font-weight: 800; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 24px 0; }
        .thank-you { text-align: center; padding: 10px 0; }
        .thank-you p { font-size: 14px; color: #475569; line-height: 1.8; }
        .btn-container { text-align: center; margin: 28px 0 16px; }
        .btn { display: inline-block; background: #16a34a; color: #ffffff !important; padding: 13px 32px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{ asset('images/logo-panti.png') }}" alt="Logo Yayasan Amaliya">
            <h1>Terima Kasih Atas Donasi Anda!</h1>
            <p>Donasi Anda telah berhasil diverifikasi</p>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Kami ingin mengabarkan bahwa donasi Anda telah kami terima dan berhasil 
                <strong>diverifikasi</strong> oleh tim bendahara Yayasan Panti Asuhan Amaliya.
            </p>

            <div class="receipt-box">
                <h3>Tanda Terima Donasi</h3>
                <div class="receipt-row">
                    <span class="receipt-label">No. Referensi</span>
                    <span class="receipt-value">#{{ $data['id_donasi'] }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Nominal Donasi</span>
                    <span class="receipt-value highlight">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Metode Pembayaran</span>
                    <span class="receipt-value">{{ $data['metode'] }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Tanggal Verifikasi</span>
                    <span class="receipt-value">{{ $data['tanggal'] }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Status</span>
                    <span class="receipt-value" style="color: #16a34a;">Terverifikasi</span>
                </div>
            </div>

            <hr class="divider">
            <div class="thank-you">
                <p>Donasi yang Anda berikan sangat berarti bagi anak-anak asuh kami.<br>Semoga kebaikan Anda dibalas dengan keberkahan yang berlimpah.</p>
            </div>

            @if($data['is_member'])
            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Lihat Kwitansi di Dashboard</a>
            </div>
            @else
            <p style="font-size: 13px; color: #94a3b8; text-align: center; margin-top: 20px;">
                Untuk mendapatkan kwitansi digital yang dapat diunduh, daftarkan diri Anda sebagai Donatur Tetap di website kami.
            </p>
            @endif
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
