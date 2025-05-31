<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pemanggilan Pelanggan</title>
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
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 50%, #2E7D32 100%);
            min-height: 100vh;
            padding: 20px;
            animation: gradientShift 3s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { background: linear-gradient(135deg, #4CAF50 0%, #45a049 50%, #2E7D32 100%); }
            100% { background: linear-gradient(135deg, #45a049 0%, #4CAF50 50%, #66BB6A 100%); }
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
            background: linear-gradient(45deg, #ff4757, #ff6b7a);
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

        .urgency-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.9);
            color: #ff4757;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .header h1 {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .bell-icon {
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
            animation: bellRing 1.5s ease-in-out infinite;
        }

        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-15deg); }
            75% { transform: rotate(15deg); }
        }

        .bell-icon::before {
            content: '🔔';
            font-size: 30px;
        }

        .content {
            padding: 40px 30px;
        }

        .urgent-message {
            background: linear-gradient(135deg, #ff6b7a, #ff4757);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 0 0 10px rgba(255, 71, 87, 0.5); }
            to { text-shadow: 0 0 20px rgba(255, 71, 87, 0.8); }
        }

        .call-notification {
            background: linear-gradient(135deg, #ff4757, #ff6b7a);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            color: white;
            box-shadow: 0 15px 35px rgba(255, 71, 87, 0.3);
            position: relative;
            overflow: hidden;
        }

        .call-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .call-title {
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

        .turn-announcement {
            background: #fff;
            border: 3px solid #4CAF50;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.2);
            animation: borderPulse 2s infinite;
        }

        @keyframes borderPulse {
            0%, 100% { border-color: #4CAF50; box-shadow: 0 10px 30px rgba(76, 175, 80, 0.2); }
            50% { border-color: #66BB6A; box-shadow: 0 15px 40px rgba(76, 175, 80, 0.4); }
        }

        .turn-text {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 15px;
        }

        .turn-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
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
            background: linear-gradient(45deg, #4CAF50, #66BB6A);
            color: white;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #2196F3, #64B5F6);
            color: white;
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.4);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .instructions {
            background: #f0f8ff;
            border-left: 5px solid #2196F3;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
        }

        .instructions h4 {
            color: #2196F3;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .instructions ul {
            color: #666;
            line-height: 1.6;
            padding-left: 20px;
        }

        .instructions li {
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

            .urgent-message {
                font-size: 24px;
            }

            .turn-text {
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
            <div class="urgency-badge">⚡ URGENT NOTIFICATION</div>
            <div class="bell-icon"></div>
            <h1>Panggilan Pelanggan</h1>
        </div>

        <div class="content">
            <div class="urgent-message">
                Saatnya Giliran Anda! 🎉
            </div>

            <div class="call-notification">
                <div class="call-title">📢 Detail Panggilan</div>

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

            <div class="turn-announcement">
                <div class="turn-text">🎯 SEKARANG GILIRAN ANDA!</div>
                <div class="turn-subtitle">Mohon segera menuju counter untuk memulai layanan</div>
            </div>

            <div class="instructions">
                <h4>📝 Petunjuk:</h4>
                <ul>
                    <li>Segera datang ke counter penerimaan</li>
                    <li>Tunjukkan email ini atau sebutkan nama Anda</li>
                    <li>Stylist kami sudah siap melayani Anda</li>
                    <li>Jika ada kendala, hubungi staff kami</li>
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
                    Email ini dikirim secara otomatis oleh sistem antrian salon
                </p>
            </div>
        </div>
    </div>
</body>
</html>