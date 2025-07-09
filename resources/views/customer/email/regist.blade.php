<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pendaftaran Pelayanan Salon</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .header h1 {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .salon-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
            z-index: 1;
        }

        .salon-icon::before {
            content: '✂';
            font-size: 24px;
            color: white;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        .booking-details {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .booking-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .detail-item:last-child {
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
            margin-right: 15px;
            font-size: 18px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: bold;
        }

        .message-section {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            border-left: 5px solid #667eea;
        }

        .message-section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .message-section p:last-child {
            margin-bottom: 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            margin: 20px auto;
            display: block;
            width: fit-content;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
            transition: transform 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
        }

        .footer {
            background: #f8f9ff;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .footer-content {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            margin: 0 10px;
            line-height: 40px;
            font-size: 16px;
        }

        .divider {
            height: 2px;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            margin: 30px 0;
            border-radius: 1px;
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

            .booking-details {
                padding: 20px;
            }

            .detail-item {
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
            <div class="salon-icon"></div>
            <h1>Konfirmasi Pendaftaran Pelayanan Salon</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Halo, {{ $name }}! 👋
            </div>

            <div class="message-section">
                <p>Terima kasih telah mempercayai layanan salon kami! Pendaftaran Anda telah berhasil dikonfirmasi dan kami sangat senang dapat melayani Anda.</p>
                <p>Berikut adalah detail pendaftaran Anda:</p>
            </div>

            <div class="booking-details">
                <div class="booking-title">📋 Detail Pendaftaran</div>

                <div class="detail-item">
                    <div class="detail-icon">👤</div>
                    <div class="detail-content">
                        <div class="detail-label">Nama Pelanggan</div>
                        <div class="detail-value">{{ $name }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">🕒</div>
                    <div class="detail-content">
                        <div class="detail-label">Nomor Antrian</div>
                        <div class="detail-value">00{{ $antri }}</div>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">💄</div>
                    <div class="detail-content">
                        <div class="detail-label">Layanan yang Dipilih</div>
                        <div class="detail-value">{{ $service }}</div>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="message-section">
                <p><strong>Catatan Penting:</strong></p>
                <p>• Harap datang 30 menit sebelum waktu appointment</p>
                <p>• Bawa kartu identitas untuk verifikasi</p>
            </div>
        </div>

        <div class="footer">
            <div class="footer-content">
                <p><strong>Beauty Salon</strong></p>
                <p>Jl. Kecantikan No. 123, Jakarta<br>
                Telp: (021) 123-4567<br>
                Email: info@beautysalon.com</p>

                <div class="social-links">
                    <a href="#">📧</a>
                    <a href="#">📱</a>
                    <a href="#">🌐</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>