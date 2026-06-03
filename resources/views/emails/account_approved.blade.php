<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun SIMPA Anda Telah Disetujui</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f1f5f9; color: #334155; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%); padding: 30px 40px; text-align: center; }
        .header img { height: 60px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { color: #bfdbfe; font-size: 13px; margin-top: 4px; }
        .content { padding: 36px 40px; }
        .greeting { font-size: 16px; margin-bottom: 14px; color: #1e293b; }
        .info-text { font-size: 14px; line-height: 1.7; color: #475569; margin-bottom: 20px; }
        .credential-box { background: #f8fafc; border: 1px solid #e2e8f0; border-left: 4px solid #1d4ed8; border-radius: 8px; padding: 20px 24px; margin: 20px 0; }
        .credential-box .label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 4px; }
        .credential-box .value { font-size: 17px; font-weight: 700; color: #1e293b; font-family: 'Courier New', monospace; letter-spacing: 1px; }
        .copy-row { display: flex; align-items: center; justify-content: space-between; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px; margin: 10px 0; }
        .copy-field { font-family: 'Courier New', monospace; font-size: 16px; font-weight: 700; color: #1e293b; letter-spacing: 1px; }
        .copy-btn { background: #dbeafe; color: #1d4ed8; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; }
        .divider { border: none; border-top: 1px solid #f1f5f9; margin: 24px 0; }
        .warning-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px; margin: 20px 0; }
        .warning-box p { font-size: 13px; color: #92400e; line-height: 1.6; }
        .btn-container { text-align: center; margin: 28px 0 16px; }
        .btn { display: inline-block; background: #1d4ed8; color: #ffffff !important; padding: 13px 32px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 14px; letter-spacing: 0.3px; }
        .footer { background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 40px; text-align: center; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <img src="{{ asset('images/logo-panti.png') }}" alt="Logo Yayasan Amaliya">
            <h1>Selamat Datang di SIMPA!</h1>
            <p>Sistem Informasi Manajemen Panti Asuhan Amaliya</p>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>!</p>
            <p class="info-text">
                Kabar baik! Permintaan pendaftaran akun Anda di SIMPA Yayasan Amaliya telah 
                <strong>disetujui</strong> oleh Admin. Berikut adalah detail login sementara Anda:
            </p>

            <div class="credential-box">
                <div class="label">Username</div>
                <div class="value">{{ $data['username'] }}</div>
            </div>

            <p style="font-size: 13px; color: #64748b; margin-bottom: 8px;">Password Sementara (klik untuk menyalin):</p>
            <div class="copy-row">
                <span class="copy-field" id="temp-password">{{ $data['password'] }}</span>
                <a href="javascript:void(0)" class="copy-btn" 
                   onclick="
                     var t = document.getElementById('temp-password').innerText;
                     navigator.clipboard.writeText(t).then(function(){ this.innerText='Tersalin!'; }.bind(this));
                   ">
                    Salin
                </a>
            </div>

            <div class="warning-box">
                <p>Demi keamanan akun Anda, sistem akan <strong>mewajibkan penggantian password</strong> ini saat pertama kali Anda login. Harap simpan password sementara di atas sebelum login.</p>
            </div>

            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Login ke SIMPA Sekarang</a>
            </div>

            <hr class="divider">
            <p class="info-text" style="font-size: 13px; text-align: center;">
                Terima kasih atas kepercayaan Anda bergabung bersama Yayasan Panti Asuhan Amaliya.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis oleh sistem, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
