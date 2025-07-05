<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pengingat Pelayanan Pelanggan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5b73e8 100%);
            min-height: 100vh;
            padding: 20px;
            animation: gradientShift 4s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #5b73e8 100%); }
            100% { background: linear-gradient(135deg, #764ba2 0%, #667eea 50%, #8b94e8 100%); }
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(45deg, #4a90e2, #5ba3f5);
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 255, 255, 0.05) 10px,
                rgba(255, 255, 255, 0.05) 20px
            );
            animation: moveStripes 8s linear infinite;
        }

        @keyframes moveStripes {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .reminder-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.9);
            color: #4a90e2;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            animation: gentlePulse 3s infinite;
        }

        @keyframes gentlePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        .header h1 {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .calendar-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            z-index: 2;
            animation: calendarFloat 2s ease-in-out infinite;
        }

        @keyframes calendarFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .calendar-icon::before {
            content: '📅';
            font-size: 30px;
        }

        .content {
            padding: 40px 30px;
        }

        .reminder-message {
            background: linear-gradient(135deg, #4a90e2, #5ba3f5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            animation: softGlow 3s ease-in-out infinite alternate;
        }

        @keyframes softGlow {
            from { text-shadow: 0 0 10px rgba(74, 144, 226, 0.3); }
            to { text-shadow: 0 0 20px rgba(74, 144, 226, 0.5); }
        }

        .appointment-info {
            background: linear-gradient(135deg, #4a90e2, #5ba3f5);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            color: white;
            box-shadow: 0 15px 35px rgba(74, 144, 226, 0.3);
            position: relative;
            overflow: hidden;
        }

        .appointment-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .appointment-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .customer-info {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 16px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 16px;
            font-weight: bold;
        }

        .reminder-announcement {
            background: #fff;
            border: 3px solid #4a90e2;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(74, 144, 226, 0.2);
            animation: borderGlow 3s infinite;
        }

        @keyframes borderGlow {
            0%, 100% { border-color: #4a90e2; box-shadow: 0 10px 30px rgba(74, 144, 226, 0.2); }
            50% { border-color: #5ba3f5; box-shadow: 0 15px 40px rgba(74, 144, 226, 0.4); }
        }

        .reminder-text {
            font-size: 28px;
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 15px;
        }

        .reminder-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .countdown-timer {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
            color: white;
            box-shadow: 0 10px 25px rgba(240, 147, 251, 0.3);
        }

        .countdown-text {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .time-remaining {
            font-size: 24px;
            font-weight: bold;
            animation: timeFlash 2s infinite;
        }

        @keyframes timeFlash {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.7; }
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px 0;
        }

        .action-btn {
            padding: 15px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4a90e2, #5ba3f5);
            color: white;
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            color: white;
            box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .preparation-tips {
            background: #f0f8ff;
            border-left: 5px solid #4a90e2;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
        }

        .preparation-tips h4 {
            color: #4a90e2;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .preparation-tips ul {
            color: #666;
            line-height: 1.6;
            padding-left: 20px;
        }

        .preparation-tips li {
            margin-bottom: 8px;
        }

        .footer {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .footer-content {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .contact-info {
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 15px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .reminder-message {
                font-size: 24px;
            }

            .reminder-text {
                font-size: 24px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="reminder-badge">🔔 PENGINGAT PELAYANAN</div>
            <div class="calendar-icon"></div>
            <h1>Pengingat Pelayanan</h1>
        </div>

        <div class="content">
            <div class="reminder-message">
                Pelayanan Anda Segera Dimulai! ⏰
            </div>

            <div class="appointment-info">
                <div class="appointment-title">📋 Detail Pelayanan</div>

                <div class="customer-info">
                    <div class="info-row">
                        <div class="info-icon">👤</div>
                        <div class="info-content">
                            <div class="info-label">Nama Pelanggan</div>
                            <div class="info-value">{{ $name }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📅</div>
                        <div class="info-content">
                            <div class="info-label">Tanggal Pelayanan</div>
                            <div class="info-value">{{ $date }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🕒</div>
                        <div class="info-content">
                            <div class="info-label">Waktu Booking</div>
                            <div class="info-value">{{ $time }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">💄</div>
                        <div class="info-content">
                            <div class="info-label">Layanan</div>
                            <div class="info-value">{{ $service }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="countdown-timer">
                <div class="countdown-text">⏳ Waktu Tersisa</div>
                <div class="time-remaining">15 Menit Lagi</div>
            </div>

            <div class="reminder-announcement">
                <div class="reminder-text">📍 Jangan Lupa!</div>
                <div class="reminder-subtitle">Silakan bersiap-siap untuk datang ke salon kami</div>
            </div>

            <div class="action-buttons">
                <a href="#" class="action-btn btn-primary">
                    📍 Lihat Lokasi
                </a>
                <a href="#" class="action-btn btn-secondary">
                    📞 Hubungi Salon
                </a>
            </div>

            <div class="preparation-tips">
                <h4>💡 Tips Persiapan:</h4>
                <ul>
                    <li>Berangkat lebih awal untuk menghindari keterlambatan</li>
                    <li>Bawa kartu identitas atau bukti booking</li>
                    <li>Siapkan metode pembayaran (tunai/kartu/e-wallet)</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <div class="footer-content">
                <p><strong>Beauty Salon</strong></p>
                <div class="contact-info">
                    <p>📍 Jl. Kecantikan No. 123, Jakarta</p>
                    <p>📞 (021) 123-4567</p>
                    <p>✉️ info@beautysalon.com</p>
                </div>
                <p style="margin-top: 15px; font-size: 12px; opacity: 0.7;">
                    Email pengingat ini dikirim secara otomatis. Terima kasih atas kepercayaan Anda.
                </p>
            </div>
        </div>
    </div>
</body>
</html>