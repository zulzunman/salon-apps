<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Pembatalan Pelayanan</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
            animation: gradientShift 4s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); }
            100% { background: linear-gradient(135deg, #764ba2 0%, #667eea 50%, #a8edea 100%); }
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
            position: relative;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(45deg, #ff7675, #fd79a8);
            padding: 45px 35px;
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
                transparent 15px,
                rgba(255, 255, 255, 0.08) 15px,
                rgba(255, 255, 255, 0.08) 30px
            );
            animation: moveStripes 10s linear infinite;
        }

        @keyframes moveStripes {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .notification-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.95);
            color: #ff7675;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            animation: pulse 2.5s infinite;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        .header h1 {
            color: white;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .bell-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            position: relative;
            z-index: 2;
            animation: bellRing 2s ease-in-out infinite;
            backdrop-filter: blur(10px);
        }

        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-20deg); }
            40% { transform: rotate(20deg); }
            60% { transform: rotate(-15deg); }
            80% { transform: rotate(15deg); }
        }

        .bell-icon::before {
            content: '🔔';
            font-size: 35px;
        }

        .content {
            padding: 45px 35px;
        }

        .main-message {
            background: linear-gradient(135deg, #ff7675, #fd79a8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 35px;
            animation: textGlow 2.5s ease-in-out infinite alternate;
            line-height: 1.3;
        }

        @keyframes textGlow {
            from {
                filter: drop-shadow(0 0 8px rgba(255, 118, 117, 0.4));
                text-shadow: 0 0 15px rgba(255, 118, 117, 0.3);
            }
            to {
                filter: drop-shadow(0 0 15px rgba(255, 118, 117, 0.7));
                text-shadow: 0 0 25px rgba(255, 118, 117, 0.5);
            }
        }

        .customer-details {
            background: linear-gradient(135deg, #ff7675, #fd79a8);
            border-radius: 25px;
            padding: 35px;
            margin: 35px 0;
            color: white;
            box-shadow: 0 20px 40px rgba(255, 118, 117, 0.3);
            position: relative;
            overflow: hidden;
        }

        .customer-details::before {
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

        .details-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .customer-info {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            backdrop-filter: blur(15px);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .info-row:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(5px);
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 18px;
            font-size: 18px;
            backdrop-filter: blur(10px);
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .info-value {
            font-size: 17px;
            font-weight: 700;
        }

        .cancellation-notice {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            border-radius: 25px;
            padding: 35px;
            text-align: center;
            margin: 35px 0;
            box-shadow: 0 15px 35px rgba(116, 185, 255, 0.3);
            animation: noticePulse 3s infinite;
            color: white;
        }

        @keyframes noticePulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 15px 35px rgba(116, 185, 255, 0.3);
            }
            50% {
                transform: scale(1.02);
                box-shadow: 0 20px 45px rgba(116, 185, 255, 0.5);
            }
        }

        .notice-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .notice-text {
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 20px;
            opacity: 0.95;
        }

        .apology-section {
            background: linear-gradient(135deg, #00b894, #00cec9);
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 184, 148, 0.2);
        }

        .apology-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .apology-text {
            font-size: 15px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .footer {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 35px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .salon-info {
            margin-bottom: 25px;
        }

        .salon-name {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3e6ea;
        }

        .contact-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            font-size: 15px;
            color: #495057;
        }

        .contact-row:last-child {
            margin-bottom: 0;
        }

        .disclaimer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
            opacity: 0.8;
        }

        @media (max-width: 650px) {
            .email-container {
                margin: 10px;
                border-radius: 20px;
            }

            .header {
                padding: 35px 25px;
            }

            .header h1 {
                font-size: 26px;
            }

            .content {
                padding: 35px 25px;
            }

            .main-message {
                font-size: 22px;
            }

            .customer-details {
                padding: 25px;
            }

            .details-title {
                font-size: 22px;
            }

            .salon-name {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="notification-badge">📋 PEMBERITAHUAN RESMI</div>
            <div class="bell-icon"></div>
            <h1>Pemberitahuan Pembatalan</h1>
        </div>

        <div class="content">
            <div class="main-message">
                Pemberitahuan Pembatalan Pelayanan Anda
            </div>

            <div class="customer-details">
                <div class="details-title">📋 Detail Pelayanan Anda</div>

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
                            <div class="info-label">Waktu Pelayanan</div>
                            <div class="info-value">{{ $time }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">💄</div>
                        <div class="info-content">
                            <div class="info-label">Layanan yang Dipesan</div>
                            <div class="info-value">{{ $service }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cancellation-notice">
                <div class="notice-title">
                    <span>ℹ️</span>
                    <span>Status Pelayanan</span>
                </div>
                <div class="notice-text">
                    Pelayanan Anda telah dibatalkan secara otomatis oleh sistem karena ketidakhadiran setelah waktu yang telah ditentukan.
                </div>
            </div>

            <div class="apology-section">
                <div class="apology-title">🙏 Mohon Maaf Atas Ketidaknyamanan Ini</div>
                <div class="apology-text">
                    Kami memahami bahwa terkadang ada hal-hal yang tidak terduga. Kami tetap menghargai Anda sebagai pelanggan dan akan dengan senang hati melayani Anda di kesempatan lain. Silakan membuat pelayanan baru kapan saja Anda membutuhkan layanan kami.
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="salon-info">
                <div class="salon-name">✨ Beauty Salon Premium ✨</div>
            </div>

            <div class="contact-info">
                <div class="contact-row">
                    <span>📍 Jl. Kecantikan Raya No. 123, Jakarta Selatan</span>
                </div>
                <div class="contact-row">
                    <span>📞 (021) 123-4567 | 📱 0812-3456-7890</span>
                </div>
                <div class="contact-row">
                    <span>✉️ pelayanan@beautysalon.com</span>
                </div>
                <div class="contact-row">
                    <span>🌐 www.beautysalon.com</span>
                </div>
            </div>

            <div class="disclaimer">
                Email ini dikirim secara otomatis oleh sistem pelayanan Beauty Salon Premium.<br>
                Terima kasih atas pengertian Anda.
            </div>
        </div>
    </div>
</body>
</html>