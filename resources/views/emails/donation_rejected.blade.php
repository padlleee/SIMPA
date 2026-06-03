<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Terkait Donasi Anda</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #7f1d1d 0%, #dc2626 100%); padding: 30px 40px; text-align: center; }
        .header img { height: 60px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; }
        .header p { color: #fecaca; font-size: 13px; margin-top: 4px; }
        .content { padding: 36px 40px; }
        .greeting { font-size: 16px; margin-bottom: 14px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 20px; }
        .rejection-box { background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #dc2626; border-radius: 8px; padding: 18px 22px; margin: 20px 0; }
        .rejection-box .label { font-size: 11px; font-weight: 700; color: #dc2626; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 8px; }
        .rejection-box .note { font-size: 14px; color: #7f1d1d; line-height: 1.7; font-style: italic; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
        .detail-row .key { font-size: 13px; color: #64748b; }
        .detail-row .val { font-size: 13px; font-weight: 600; color: #1e293b; }
        .info-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin-top: 20px; }
        .info-box p { font-size: 13px; color: #92400e; line-height: 1.6; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{ asset('images/logo-panti.png') }}" alt="Logo Yayasan Amaliya">
            <h1>Pemberitahuan Donasi</h1>
            <p>Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Terima kasih atas niat baik Anda untuk berdonasi. Namun setelah tim kami melakukan 
                pengecekan, donasi berikut ini belum dapat kami verifikasi dan <strong>ditolak</strong>.
            </p>

            <div class="detail-row">
                <span class="key">Nominal</span>
                <span class="val">Rp {{ number_format($data['nominal'], 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="key">Status</span>
                <span class="val" style="color: #dc2626;">Ditolak</span>
            </div>

            <div class="rejection-box">
                <div class="label">Catatan dari Admin</div>
                <div class="note">"{{ $data['catatan'] }}"</div>
            </div>

            <div class="info-box">
                <p>Jika Anda merasa ini adalah kesalahan atau ingin mencoba kembali, silakan mengunggah ulang bukti transfer melalui form donasi di website kami, atau hubungi pengurus panti asuhan secara langsung.</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
