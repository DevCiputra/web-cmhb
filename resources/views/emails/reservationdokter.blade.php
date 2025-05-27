<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Jadwal Reservasi</title>
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
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px;
        }

        .header img {
            max-width: 150px;
            height: auto;
            margin-bottom: 15px;
        }

        .header h1 {
            color: white;
            font-size: 26px;
            font-weight: 600;
            margin: 0;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .reservation-card {
            background-color: #f8fafc;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }

        .reservation-title {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .reservation-title::before {
            content: "📅";
            margin-right: 10px;
            font-size: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 12px;
            font-weight: 500;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 15px;
            font-weight: 500;
            color: #2d3748;
        }

        .datetime-highlight {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }

        .datetime-highlight .date {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .datetime-highlight .time {
            font-size: 16px;
            opacity: 0.9;
        }

        .complaint-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #fffaf0;
            border-radius: 8px;
            border-left: 4px solid #f6ad55;
        }

        .complaint-section h3 {
            margin: 0 0 10px 0;
            color: #744210;
            font-size: 16px;
            font-weight: 600;
        }

        .complaint-section p {
            margin: 0;
            color: #744210;
            font-size: 15px;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            justify-content: center;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            min-width: 140px;
        }

        .btn-approve {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(72, 187, 120, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(72, 187, 120, 0.4);
        }

        .btn-reschedule {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(237, 137, 54, 0.3);
        }

        .btn-reschedule:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(237, 137, 54, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(245, 101, 101, 0.3);
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(245, 101, 101, 0.4);
        }

        .notes {
            background-color: #e6fffa;
            border: 1px solid #81e6d9;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .notes h4 {
            color: #234e52;
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .notes ul {
            margin: 0;
            color: #234e52;
            font-size: 14px;
        }

        .notes li {
            margin-bottom: 5px;
        }

        .footer {
            background-color: #f7fafc;
            text-align: center;
            padding: 25px;
            color: #718096;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .emergency-contact {
            background-color: #fed7d7;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .emergency-contact h4 {
            color: #c53030;
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: 600;
        }

        .emergency-contact p {
            color: #c53030;
            margin: 0;
            font-size: 14px;
            font-weight: 500;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .content {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
            }

            .header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-card">
            <div class="header">
                <img src="/api/placeholder/200/60" alt="Ciputra Mitra Hospital" />
                <h1>Konfirmasi Jadwal Reservasi</h1>
                <p>Permintaan konsultasi dari pasien</p>
            </div>

            <div class="content">
                <div class="greeting">
                    Halo Dokter,
                </div>

                <p>Anda telah menerima permintaan reservasi konsultasi baru. Mohon untuk meninjau detail reservasi di aplikasi mobile anda.</p>

                <div class="notes">
                    <h4>📝 Catatan Penting:</h4>
                    <ul>
                        <li>Silakan konfirmasi ketersediaan jadwal Anda dalam waktu <strong>24 jam</strong></li>
                        <li>Jika jadwal tidak sesuai, gunakan opsi "Reschedule" untuk memberikan jadwal alternatif</li>
                        <li>Pasien akan mendapat notifikasi otomatis setelah Anda memberikan konfirmasi</li>
                        <li>Untuk konsultasi online, link meeting akan dikirim setelah pembayaran pasien</li>
                    </ul>
                </div>

                 <div class="content">
                    <div class="otp-container">
                        <div class="otp-code">{{ $status_reservation }}</div>
                    </div>
                </div>


                <p style="margin-top: 30px; font-size: 14px; color: #718096;">
                    <strong>Butuh bantuan?</strong> Hubungi admin rumah sakit di
                    <a href="tel:+628787878" style="color: #667eea;">+628787878</a> atau
                    <a href="mailto:admin@ciputramitrahospital.com" style="color: #667eea;">admin@ciputramitrahospital.com</a>
                </p>
            </div>

            <div class="footer">
                <p><strong>Ciputra Mitra Hospital</strong></p>
                <p>Jl. Ahmad Yani, KM 6,7, Perumahan Citra Land, Banjar, Kalimantan Selatan</p>
                <p>Email: <a href="mailto:admin@ciputramitrahospital.com">admin@ciputramitrahospital.com</a> | Telp: +628787878</p>
                <p>&copy; {{ date('YdmHis') }} Ciputra Mitra Hospital. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
