<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tanggal & Jam - Salon Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .booking-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            color: #333;
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        /* Main Layout */
        .booking-layout {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        /* Calendar Styles - Smaller and on the left */
        .calendar-container {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            flex: 0 0 350px;
            /* Fixed width for calendar */
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 0 5px;
        }

        .calendar-nav {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .calendar-nav:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .calendar-month {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            flex: 1;
            text-align: center;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: #666;
            padding: 8px 3px;
            font-size: 0.8rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.9rem;
            position: relative;
        }

        .calendar-day:not(.disabled):not(.other-month):hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
        }

        .calendar-day.other-month {
            color: #ddd;
            cursor: not-allowed;
        }

        .calendar-day.today {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            font-weight: 600;
        }

        /* Time Selection Styles - On the right */
        .time-container {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            flex: 1;
            min-height: 400px;
        }

        .time-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .time-slot {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
        }

        .time-slot:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .time-slot.selected {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            transform: scale(1.05);
        }

        .time-slot.unavailable {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .time-slot .remaining-info {
            font-size: 0.75rem;
            opacity: 0.8;
            margin-top: 5px;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            color: #666;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .continue-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
        }

        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .continue-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .loading-spinner {
            display: none;
            margin: 50px auto;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            border-left: 4px solid #667eea;
        }

        /* Service Selection Warning */
        .service-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 152, 0, 0.1) 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .booking-layout {
                flex-direction: column;
                gap: 20px;
            }

            .calendar-container {
                flex: none;
                max-width: 100%;
            }

            .calendar-grid {
                gap: 8px;
            }

            .time-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 20px;
                margin: 10px;
            }

            .calendar-grid {
                gap: 5px;
            }

            .time-grid {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 10px;
            }

            .calendar-day {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="booking-container">
            <h1 class="section-title">
                <i class="bi bi-calendar-check me-2"></i>
                Pilih Tanggal & Jam Booking
            </h1>

            <!-- Warning jika belum pilih service -->
            <div class="alert service-warning" id="serviceWarning" style="display: none;">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Anda belum memilih layanan. Silakan pilih layanan terlebih dahulu di halaman utama.
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Silakan pilih tanggal dan jam yang tersedia. Maksimal 3 customer per jam.
            </div>

            <!-- Main Layout: Calendar on left, Time on right -->
            <div class="booking-layout">
                <!-- Calendar Section -->
                <div class="calendar-container">
                    <h4 class="mb-3">
                        <i class="bi bi-calendar3 me-2"></i>
                        Pilih Tanggal
                    </h4>

                    <div class="calendar-header">
                        <button class="calendar-nav" id="prevMonth">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div class="calendar-month" id="currentMonth"></div>
                        <button class="calendar-nav" id="nextMonth">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                    <div class="calendar-grid" id="calendarGrid">
                        <!-- Calendar will be generated by JavaScript -->
                    </div>
                </div>

                <!-- Time Selection Section -->
                <div class="time-container">
                    <h4 class="mb-3">
                        <i class="bi bi-clock me-2"></i>
                        Pilih Jam
                    </h4>

                    <div id="timeEmpty" class="empty-state">
                        <i class="bi bi-clock-history"></i>
                        <p>Pilih tanggal terlebih dahulu untuk melihat jam yang tersedia</p>
                    </div>

                    <div class="loading-spinner" id="loadingSpinner"></div>
                    <div class="time-grid" id="timeGrid">
                        <!-- Times will be loaded via AJAX -->
                    </div>
                </div>
            </div>

            <!-- Continue Button -->
            <div class="text-center mt-4">
                <button class="continue-btn" id="continueBtn" disabled onclick="proceedToRegistration()">
                    <i class="bi bi-arrow-right me-2"></i>
                    Lanjut ke Pendaftaran
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="/" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTimeId = null;
        let selectedServiceId = null;

        // Initialize calendar
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil service_id dari URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            selectedServiceId = urlParams.get('service_id');

            // Debug log
            console.log('Selected Service ID:', selectedServiceId);

            // Cek apakah service_id ada
            if (!selectedServiceId) {
                document.getElementById('serviceWarning').style.display = 'block';
                // Disable calendar jika tidak ada service
                document.getElementById('calendarGrid').style.opacity = '0.5';
                document.getElementById('calendarGrid').style.pointerEvents = 'none';
                return;
            }

            generateCalendar();

            document.getElementById('prevMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar();
                hideTimeSelection();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar();
                hideTimeSelection();
            });
        });

        function generateCalendar() {
            const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            // Update month display
            document.getElementById('currentMonth').textContent =
                monthNames[currentDate.getMonth()] + ' ' + currentDate.getFullYear();

            const grid = document.getElementById('calendarGrid');
            grid.innerHTML = '';

            // Add day headers
            dayNames.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'calendar-day-header';
                dayHeader.textContent = day;
                grid.appendChild(dayHeader);
            });

            // Get first day of month and number of days
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const today = new Date();

            // Calculate starting day (Sunday = 0)
            const startDate = new Date(firstDay);
            startDate.setDate(startDate.getDate() - firstDay.getDay());

            // Generate 42 days (6 weeks)
            for (let i = 0; i < 42; i++) {
                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);

                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = date.getDate();

                // Add classes based on date status
                if (date.getMonth() !== currentDate.getMonth()) {
                    dayElement.classList.add('other-month');
                } else if (date < today.setHours(0, 0, 0, 0)) {
                    dayElement.classList.add('disabled');
                } else {
                    if (date.toDateString() === today.toDateString()) {
                        dayElement.classList.add('today');
                    }

                    // Store date data untuk event handler
                    dayElement.setAttribute('data-date', date.toISOString().split('T')[0]);

                    dayElement.addEventListener('click', function() {
                        selectDate(this.getAttribute('data-date'), this);
                    });
                }

                grid.appendChild(dayElement);
            }
        }

        function selectDate(dateString, element) {
            // Remove previous selection
            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                el.classList.remove('selected');
            });

            // Add selection to clicked date
            element.classList.add('selected');

            selectedDate = dateString;
            selectedTimeId = null; // Reset time selection

            console.log('Selected date:', selectedDate);

            // Show time selection and load available times
            showTimeSelection();
            loadAvailableTimes(selectedDate);
        }

        function showTimeSelection() {
            document.getElementById('timeEmpty').style.display = 'none';
            document.getElementById('continueBtn').disabled = true;
        }

        function hideTimeSelection() {
            document.getElementById('timeEmpty').style.display = 'flex';
            document.getElementById('timeGrid').innerHTML = '';
            document.getElementById('continueBtn').disabled = true;
            selectedDate = null;
            selectedTimeId = null;
        }

        function loadAvailableTimes(date) {
            const spinner = document.getElementById('loadingSpinner');
            const timeGrid = document.getElementById('timeGrid');

            spinner.style.display = 'block';
            timeGrid.innerHTML = '';

            console.log('Loading times for date:', date);

            fetch(`/booking/times/${date}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    spinner.style.display = 'none';
                    console.log('Times data:', data);

                    if (data.times && data.times.length > 0) {
                        data.times.forEach(time => {
                            const timeSlot = document.createElement('div');
                            timeSlot.className = 'time-slot';
                            timeSlot.innerHTML = `
                                <div>${time.time}</div>
                                <div class="remaining-info">${time.remaining_slots} slot tersisa</div>
                            `;

                            // Store time id untuk event handler
                            timeSlot.setAttribute('data-time-id', time.id);

                            timeSlot.addEventListener('click', function() {
                                selectTime(this.getAttribute('data-time-id'), this);
                            });

                            timeGrid.appendChild(timeSlot);
                        });
                    } else {
                        timeGrid.innerHTML =
                            '<div class="alert alert-warning">Tidak ada jam yang tersedia untuk tanggal ini.</div>';
                    }
                })
                .catch(error => {
                    spinner.style.display = 'none';
                    console.error('Error loading times:', error);
                    timeGrid.innerHTML =
                        '<div class="alert alert-danger">Terjadi kesalahan saat memuat jam yang tersedia.</div>';
                });
        }

        function selectTime(timeId, element) {
            // Remove previous selection
            document.querySelectorAll('.time-slot.selected').forEach(el => {
                el.classList.remove('selected');
            });

            // Add selection to clicked time
            element.classList.add('selected');

            selectedTimeId = timeId;
            document.getElementById('continueBtn').disabled = false;

            console.log('Selected time ID:', selectedTimeId);
        }

        function proceedToRegistration() {
            console.log('Proceeding to registration...');
            console.log('Selected date:', selectedDate);
            console.log('Selected time ID:', selectedTimeId);
            console.log('Selected service ID:', selectedServiceId);

            if (!selectedServiceId) {
                alert('Silakan pilih layanan terlebih dahulu di halaman utama');
                return;
            }

            if (selectedDate && selectedTimeId) {
                // Konstruksi URL dengan parameter
                let url =
                    `/registration/add-data?booking_date=${selectedDate}&booking_time_id=${selectedTimeId}&service_id=${selectedServiceId}`;

                console.log('Redirecting to:', url);
                window.location.href = url;
            } else {
                alert('Silakan pilih tanggal dan jam terlebih dahulu');
            }
        }
    </script>
</body>

</html>
