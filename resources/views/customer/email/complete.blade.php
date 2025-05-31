<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pelayanan Salon</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            padding: 20px;
            animation: backgroundGlow 5s ease-in-out infinite alternate;
        }

        @keyframes backgroundGlow {
            0% { background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); }
            100% { background: linear-gradient(135deg, #f093fb 0%, #667eea 50%, #764ba2 100%); }
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 25px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
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
            background: linear-gradient(45deg, #4CAF50, #81C784);
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zM10 30c0-11.046 8.954-20 20-20s20 8.954 20 20-8.954 20-20 20-20-8.954-20-20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: patternMove 10s linear infinite;
        }

        @keyframes patternMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(60px) translateY(60px); }
        }

        .success-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.9);
            color: #4CAF50;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .header h1 {
            color: white;
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .completion-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            position: relative;
            z-index: 2;
            animation: checkmarkPop 1.5s ease-out 0.5s both;
        }

        @keyframes checkmarkPop {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); opacity: 1; }
        }

        .completion-icon::before {
            content: '✅';
            font-size: 35px;
        }

        .content {
            padding: 50px 40px;
        }

        .completion-message {
            text-align: center;
            margin-bottom: 40px;
        }

        .thank-you-text {
            background: linear-gradient(45deg, #4CAF50, #81C784);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 15px;
            animation: textGlow 3s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            from { filter: brightness(1); }
            to { filter: brightness(1.2); }
        }

        .completion-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .service-summary {
            background: linear-gradient(135deg, #4CAF50, #81C784);
            border-radius: 20px;
            padding: 35px;
            margin: 30px 0;
            color: white;
            box-shadow: 0 15px 40px rgba(76, 175, 80, 0.3);
            position: relative;
            overflow: hidden;
        }

        .service-summary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 4s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .summary-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .service-details {
            position: relative;
            z-index: 1;
        }

        .detail-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 18px;
            font-size: 16px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 17px;
            font-weight: bold;
        }

        .completion-announcement {
            background: linear-gradient(135deg, #FF6B6B, #FF8E53);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin: 35px 0;
            color: white;
            box-shadow: 0 15px 40px rgba(255, 107, 107, 0.3);
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { box-shadow: 0 15px 40px rgba(255, 107, 107, 0.3); }
            to { box-shadow: 0 20px 50px rgba(255, 107, 107, 0.5); }
        }

        .completion-text {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .completion-subtext {
            font-size: 16px;
            opacity: 0.9;
        }

        .satisfaction-section {
            background: #f8f9ff;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            border: 2px solid #e3f2fd;
        }

        .satisfaction-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .rating-section {
            margin: 25px 0;
        }

        .stars {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .star {
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s ease;
            margin: 0 5px;
            animation: starFloat 3s ease-in-out infinite;
        }

        .star:nth-child(1) { animation-delay: 0s; }
        .star:nth-child(2) { animation-delay: 0.2s; }
        .star:nth-child(3) { animation-delay: 0.4s; }
        .star:nth-child(4) { animation-delay: 0.6s; }
        .star:nth-child(5) { animation-delay: 0.8s; }

        @keyframes starFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }

        .star.gold {
            color: #FFD700;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 35px 0;
        }

        .action-btn {
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4CAF50, #81C784);
            color: white;
            box-shadow: 0 5px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(45deg, #2196F3, #64B5F6);
            color: white;
            box-shadow: 0 5px 20px rgba(33, 150, 243, 0.4);
        }

        .btn-tertiary {
            background: linear-gradient(45deg, #FF9800, #FFB74D);
            color: white;
            box-shadow: 0 5px 20px rgba(255, 152, 0, 0.4);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .next-steps {
            background: #e8f5e8;
            border-left: 5px solid #4CAF50;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
        }

        .next-steps h4 {
            color: #4CAF50;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .next-steps ul {
            color: #666;
            line-height: 1.8;
            padding-left: 20px;
        }

        .next-steps li {
            margin-bottom: 10px;
        }

        .footer {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 40px 30px;
            text-align: center;
        }

        .footer-content {
            color: #666;
            font-size: 14px;
            line-height: 1.8;
        }

        .salon-info {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
        }

        .social-links {
            margin-top: 25px;
        }

        .social-links a {
            display: inline-block;
            width: 45px;
            height: 45px;
            background: linear-gradient(45deg, #4CAF50, #81C784);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            margin: 0 10px;
            line-height: 45px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: scale(1.1);
        }

        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 20px;
            }

            .header {
                padding: 40px 25px;
            }

            .header h1 {
                font-size: 26px;
            }

            .content {
                padding: 40px 25px;
            }

            .thank-you-text {
                font-size: 28px;
            }

            .completion-text {
                font-size: 22px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .detail-row {
                flex-direction: column;
                text-align: center;
            }

            .detail-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="success-badge">✨ SERVICE COMPLETED</div>
            <div class="completion-icon"></div>
            <h1>Pelayanan Selesai</h1>
        </div>

        <div class="content">
            <div class="completion-message">
                <div class="thank-you-text">Terima Kasih! 🌟</div>
                <div class="completion-subtitle">Kami berharap Anda puas dengan layanan kami</div>
            </div>

            <div class="service-summary">
                <div class="summary-title">📋 Ringkasan Layanan</div>

                <div class="service-details">
                    <div class="detail-row">
                        <div class="detail-icon">👤</div>
                        <div class="detail-content">
                            <div class="detail-label">Nama Pelanggan</div>
                            <div class="detail-value">{{ $name }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon">📅</div>
                        <div class="detail-content">
                            <div class="detail-label">Tanggal Pelayanan</div>
                            <div class="detail-value">{{ $date }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon">🕒</div>
                        <div class="detail-content">
                            <div class="detail-label">Waktu Layanan</div>
                            <div class="detail-value">{{ $time }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-icon">💄</div>
                        <div class="detail-content">
                            <div class="detail-label">Layanan yang Diterima</div>
                            <div class="detail-value">{{ $service }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="completion-announcement">
                <div class="completion-text">🎉 PELAYANAN ANDA TELAH SELESAI!</div>
                <div class="completion-subtext">Semoga Anda merasa lebih percaya diri dan cantik</div>
            </div>

            <div class="next-steps">
                <h4>💡 Tips Perawatan Selanjutnya:</h4>
                <ul>
                    <li>Gunakan produk perawatan yang direkomendasikan</li>
                    <li>Hindari aktivitas yang dapat merusak hasil styling</li>
                    <li>Booking treatment rutin untuk hasil optimal</li>
                    <li>Hubungi kami jika ada pertanyaan</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <div class="footer-content">
                <p><strong>Beauty Salon</strong></p>
                <div class="salon-info">
                    <p>📍 Jl. Kecantikan No. 123, Jakarta</p>
                    <p>📞 (021) 123-4567</p>
                    <p>✉️ info@beautysalon.com</p>
                    <p>🕒 Buka: Senin - Minggu, 09:00 - 21:00</p>
                </div>

                <div class="social-links">
                    <a href="#">📧</a>
                    <a href="#">📱</a>
                    <a href="#">🌐</a>
                    <a href="#">📷</a>
                </div>

                <p style="margin-top: 20px; font-size: 12px; opacity: 0.7;">
                    Terima kasih telah mempercayakan kecantikan Anda kepada kami!
                </p>
            </div>
        </div>
    </div>
</body>
</html>