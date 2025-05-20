<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-top: 20px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .header img {
            max-width: 150px;
            height: auto;
        }

        .content {
            padding: 30px 0;
            text-align: center;
        }

        h1 {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 25px;
        }

        .otp-container {
            margin: 30px 0;
        }

        .otp-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 5px;
            padding: 15px 30px;
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .warning {
            margin-top: 30px;
            padding: 15px;
            background-color: #fffaf0;
            border-left: 4px solid #f6ad55;
            border-radius: 4px;
            font-size: 14px;
            color: #744210;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            color: #718096;
            font-size: 14px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .email-card {
                padding: 20px;
            }

            h1 {
                font-size: 22px;
            }

            .otp-code {
                font-size: 24px;
                padding: 12px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-card">
            <div class="header">
                <img src="/api/placeholder/200/60" alt="Logo" />
                <h1>Verifikasi Email</h1>
            </div>

            <div class="content">
                <p>Terima kasih telah mendaftar. Untuk melanjutkan proses, masukkan kode OTP berikut:</p>

                <div class="otp-container">
                    <div class="otp-code">{{ $otp }}</div>
                </div>

                <p>Kode ini berlaku selama 10 menit.</p>

                <div class="warning">
                    <strong>Perhatian:</strong> Jangan berikan kode ini kepada siapa pun, termasuk pihak yang mengaku sebagai staf kami. Kami tidak pernah meminta kode verifikasi Anda melalui telepon atau email.
                </div>
            </div>

            <div class="footer">
                <p>Jl. Ahmad Yani, KM 6,7, Perumahan Citra Land, Banjar, Kalimantan Selatan</p>
                <p>Email: <a href="mailto:auth@ciputramitrahospital" style="color: #17a2b8;">auth@ciputramitrahospital</a> | Telp: +628787878</p>
                <p>&copy; {{ date('YdmHis') }}</p>
            </div>
        </div>
    </div>
</body>

</html>