<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemulihan Password SIMPA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #c2410c 0%, #ea580c 100%); padding: 30px 40px; text-align: center; }
        .header img { height: 60px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; }
        .header p { color: #fed7aa; font-size: 13px; margin-top: 4px; }
        .content { padding: 36px 40px; }
        .greeting { font-size: 16px; margin-bottom: 14px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 20px; }
        .copy-row { display: flex; align-items: center; justify-content: space-between; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 16px 18px; margin: 14px 0; }
        .copy-field { font-family: 'Courier New', monospace; font-size: 20px; font-weight: 700; color: #9a3412; letter-spacing: 2px; }
        .copy-btn { background: #ea580c; color: #ffffff; border: none; border-radius: 6px; padding: 8px 16px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .warning-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin: 20px 0; }
        .warning-box p { font-size: 13px; color: #92400e; line-height: 1.6; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 24px 0; }
        .btn-container { text-align: center; margin: 28px 0 16px; }
        .btn { display: inline-block; background: #ea580c; color: #ffffff !important; padding: 13px 32px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{ asset('images/logo-panti.png') }}" alt="Logo Yayasan Amaliya">
            <h1>Pemulihan Akun SIMPA</h1>
            <p>Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Sistem kami menerima permintaan untuk mereset password akun Anda di SIMPA. 
                Berikut adalah <strong>password sementara</strong> baru Anda:
            </p>

            <p style="font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 600;">Password Sementara (klik tombol untuk menyalin):</p>
            <div class="copy-row">
                <span class="copy-field" id="temp-pass">{{ $data['temp_password'] }}</span>
                <a href="javascript:void(0)" class="copy-btn" id="copyBtn"
                   onclick="
                     var t = document.getElementById('temp-pass').innerText;
                     navigator.clipboard.writeText(t).then(function(){ document.getElementById('copyBtn').innerText='Tersalin!'; });
                   ">
                    Salin Password
                </a>
            </div>

            <div class="warning-box">
                <p>Gunakan password di atas untuk masuk ke akun Anda. Setelah berhasil login, Anda <strong>wajib segera mengganti</strong> password sementara tersebut demi keamanan akun Anda.</p>
            </div>

            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Login Sekarang</a>
            </div>

            <hr class="divider">
            <p class="info-text" style="font-size: 13px; color: #94a3b8; text-align: center;">
                Jika Anda tidak merasa meminta reset password, harap segera hubungi administrator panti asuhan.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
