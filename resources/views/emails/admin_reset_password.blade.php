<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Diubah Admin</title>
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
        .data-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0; text-align: center; }
        .data-box .label { font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .data-box .value { font-size: 22px; font-weight: 700; color: #0f172a; font-family: 'Courier New', monospace; letter-spacing: 2px; padding: 10px 20px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 6px; display: inline-block; user-select: all; }
        .warning-box { background: #fffbeb; border-left: 4px solid #f59e0b; padding: 12px 16px; margin: 20px 0; border-radius: 0 8px 8px 0; }
        .warning-box p { font-size: 13px; color: #92400e; margin: 0; }
        .btn-container { text-align: center; margin: 30px 0 10px; }
        .btn { display: inline-block; background: #2563eb; color: #ffffff !important; padding: 12px 28px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; }
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
                        <h1>Password Diubah Admin</h1>
                        <p>Pemberitahuan Otomatis SIMPA</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <p class="greeting">Halo, <strong>{{ $data['name'] }}</strong>,</p>
            <p class="info-text">
                Administrator SIMPA baru saja mereset kata sandi akun Anda. 
                Berikut adalah kredensial sementara Anda untuk masuk kembali:
            </p>
            <div class="data-box">
                <div class="label">Username</div>
                <div class="value" style="margin-bottom: 15px; background: transparent; border: none; font-size: 18px; padding: 0;">{{ $data['username'] }}</div>
                
                <div class="label">Password Sementara Baru</div>
                <div class="value">{{ $data['temp_password'] }}</div>
                <p style="font-size: 11px; color: #64748b; margin-top: 8px;">(Sorot teks di atas untuk menyalin)</p>
            </div>
            <div class="warning-box">
                <p>Silakan segera login dan ganti password Anda melalui menu profil untuk menjaga keamanan akun.</p>
            </div>
            <div class="btn-container">
                <a href="{{ url('/') }}" class="btn">Masuk ke Dashboard</a>
            </div>
        </div>
        <div class="footer">
            <p>Pesan ini merupakan pemberitahuan otomatis dari sistem SIMPA (Sistem Informasi Manajemen Panti Asuhan).</p>
            <p>&copy; {{ date('Y') }} Yayasan Panti Asuhan Amaliya. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>
