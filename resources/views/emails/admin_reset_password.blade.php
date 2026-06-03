<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Perubahan Password Akun</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%); padding: 30px 40px; text-align: center; }
        .header img { height: 60px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; }
        .header p { color: #fecaca; font-size: 13px; margin-top: 4px; }
        .content { padding: 36px 40px; }
        .greeting { font-size: 16px; margin-bottom: 14px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 20px; }
        .credential-block { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 22px; margin: 14px 0; }
        .credential-block .label { font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 3px; }
        .credential-block .value { font-size: 15px; font-weight: 700; color: #1e293b; font-family: 'Courier New', monospace; }
        .copy-row { display: flex; align-items: center; justify-content: space-between; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 8px; padding: 16px 18px; margin: 14px 0; }
        .copy-field { font-family: 'Courier New', monospace; font-size: 20px; font-weight: 700; color: #9f1239; letter-spacing: 2px; }
        .copy-btn { background: #dc2626; color: #ffffff; border: none; border-radius: 6px; padding: 8px 16px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .warning-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin: 20px 0; }
        .warning-box p { font-size: 13px; color: #92400e; line-height: 1.6; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 24px 0; }
        .btn-container { text-align: center; margin: 28px 0 16px; }
        .btn { display: inline-block; background: #dc2626; color: #ffffff !important; padding: 13px 32px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{ asset('images/logo-panti.png') }}" alt="Logo Yayasan Amaliya">
            <h1>Password Anda Telah Direset</h1>
            <p>Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Administrator SIMPA Yayasan Amaliya baru saja mereset kata sandi akun Anda. 
                Berikut adalah kredensial sementara Anda untuk masuk kembali:
            </p>

            <div class="credential-block">
                <div class="label">Username</div>
                <div class="value">{{ $data['username'] }}</div>
            </div>

            <p style="font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 600;">Password Sementara (klik tombol untuk menyalin):</p>
            <div class="copy-row">
                <span class="copy-field" id="new-pass">{{ $data['temp_password'] }}</span>
                <a href="javascript:void(0)" class="copy-btn" id="copyBtn2"
                   onclick="
                     var t = document.getElementById('new-pass').innerText;
                     navigator.clipboard.writeText(t).then(function(){ document.getElementById('copyBtn2').innerText='Tersalin!'; });
                   ">
                    Salin Password
                </a>
            </div>

            <div class="warning-box">
                <p>Silakan segera login dan ganti password Anda melalui menu profil untuk menjaga keamanan akun Anda.</p>
            </div>

            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Login ke Dashboard</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
