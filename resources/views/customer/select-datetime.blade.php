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
    <link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
    <style>
        /* Additional styles for disabled/past times */
        .time-slot.disabled,
        .time-slot.past-time {
            background-color: #f8f9fa;
            color: #6c757d;
            text-decoration: line-through;
            cursor: not-allowed;
            opacity: 0.6;
            border: 1px solid #dee2e6;
            position: relative;
        }

        .time-slot.disabled:hover,
        .time-slot.past-time:hover {
            background-color: #f8f9fa;
            transform: none;
            box-shadow: none;
        }

        .time-slot.disabled .remaining-info,
        .time-slot.past-time .remaining-info {
            color: #adb5bd;
        }

        .past-time-indicator {
            font-size: 0.75rem;
            color: #dc3545;
            font-style: italic;
        }

        /* Strike-through effect for past times */
        .time-slot.past-time::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            height: 2px;
            background-color: #dc3545;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* Current Time Display Styles - Mini version for corner */
        .time-header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .current-time-corner {
            position: relative;
        }

        .current-time-card-mini {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 16px;
            border-radius: 12px;
            text-align: center;
            min-width: 140px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            animation: pulse-glow-mini 3s infinite alternate;
        }

        .current-time-mini {
            font-size: 1.1rem;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .current-date-mini {
            font-size: 0.75rem;
            opacity: 0.9;
            font-weight: 500;
        }

        @keyframes pulse-glow-mini {
            0% {
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            100% {
                box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            }
        }

        /* Digital clock animation */
        .current-time-mini {
            animation: digital-flicker 1s infinite;
        }

        @keyframes digital-flicker {

            0%,
            98% {
                opacity: 1;
            }

            99%,
            100% {
                opacity: 0.8;
            }
        }

        /* Full slot indicator */
        .time-slot.full-slot {
            background-color: #fff3cd;
            border-color: #ffeaa7;
            color: #856404;
        }

        .time-slot.full-slot .remaining-info {
            color: #856404;
            font-weight: bold;
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

            @if (!$selectedServiceId)
                <div class="alert service-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Anda belum memilih layanan. Silakan pilih layanan terlebih dahulu di halaman utama.
                </div>
            @endif

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                Silakan pilih tanggal dan jam yang tersedia. Maksimal 3 customer per jam.
            </div>

            <form action="{{ route('register.form-add') }}" method="GET" id="bookingForm">
                <input type="hidden" name="service_id" value="{{ $selectedServiceId }}">

                <div class="booking-layout">
                    <!-- Calendar Section -->
                    <div class="calendar-container">
                        <h4 class="mb-3">
                            <i class="bi bi-calendar3 me-2"></i>
                            Pilih Tanggal
                        </h4>
                        <div class="calendar-header">
                            <a href="?service_id={{ $selectedServiceId }}&month={{ $prevMonth }}"
                                class="calendar-nav">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                            <div class="calendar-month">{{ $currentMonthName }}</div>
                            <a href="?service_id={{ $selectedServiceId }}&month={{ $nextMonth }}"
                                class="calendar-nav">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                        <div class="calendar-grid">
                            <!-- Day headers -->
                            @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                                <div class="calendar-day-header">{{ $day }}</div>
                            @endforeach

                            <!-- Calendar days -->
                            @foreach ($calendarDays as $day)
                                <div class="calendar-day {{ $day['class'] }} {{ $selectedDate == $day['date'] ? 'selected' : '' }}"
                                    @if ($day['selectable']) onclick="selectDate('{{ $day['date'] }}')" @endif>
                                    {{ $day['number'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Time Selection Section -->
                    <div class="time-container">
                        <div class="time-header-container">
                            <h4 class="mb-3">
                                <i class="bi bi-clock me-2"></i>
                                Pilih Jam
                            </h4>

                            <!-- Current Time Display - Moved to corner -->
                            <div class="current-time-corner">
                                <div class="current-time-card-mini">
                                    <div class="current-time-mini" id="currentTime"></div>
                                    <div class="current-date-mini" id="currentDate"></div>
                                </div>
                            </div>
                        </div>

                        @if (!$selectedDate)
                            <div class="empty-state">
                                <i class="bi bi-clock-history"></i>
                                <p>Pilih tanggal terlebih dahulu untuk melihat jam yang tersedia</p>
                            </div>
                        @else
                            <div class="time-grid" id="timeGrid">
                                @forelse($availableTimes as $time)
                                    <div class="time-slot {{ $selectedTimeId == $time['id'] ? 'selected' : '' }} 
                                         {{ $time['is_past'] ? 'past-time disabled' : '' }} 
                                         {{ $time['is_full'] ? 'full-slot' : '' }}"
                                        data-time-id="{{ $time['id'] }}" data-time="{{ $time['time'] }}"
                                        data-can-select="{{ $time['can_select'] ? 'true' : 'false' }}"
                                        @if ($time['can_select']) onclick="selectTime({{ $time['id'] }})" @endif>
                                        <div>{{ $time['time'] }}</div>
                                        @if ($time['is_past'])
                                            <div class="past-time-indicator">Waktu sudah lewat</div>
                                        @elseif ($time['is_full'])
                                            <div class="remaining-info">Penuh (0 slot tersisa)</div>
                                        @else
                                            <div class="remaining-info">{{ $time['remaining_slots'] }} slot tersisa
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="alert alert-warning">
                                        Tidak ada jam yang tersedia untuk tanggal ini.
                                    </div>
                                @endforelse
                            </div>

                            @if (collect($availableTimes)->where('can_select', true)->isEmpty() && !empty($availableTimes))
                                <div class="alert alert-warning mt-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    @if ($selectedDate == $currentDate)
                                        Semua jam untuk hari ini sudah lewat atau penuh. Silakan pilih tanggal lain.
                                    @else
                                        Semua jam untuk tanggal ini sudah penuh. Silakan pilih tanggal lain.
                                    @endif
                                </div>
                            @endif
                        @endif

                        <!-- Notifikasi untuk jam yang sudah lewat atau penuh -->
                        @if ($selectedDate && collect($availableTimes)->where('can_select', true)->isEmpty() && !empty($availableTimes))
                            <div class="alert alert-warning mt-3" id="timeWarning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                @if ($selectedDate == $currentDate)
                                    Semua jam untuk hari ini sudah lewat atau penuh. Silakan pilih tanggal lain.
                                @else
                                    Semua jam untuk tanggal ini sudah penuh. Silakan pilih tanggal lain.
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <input type="hidden" name="booking_date" id="selectedDateInput" value="{{ $selectedDate }}">
                <input type="hidden" name="booking_time_id" id="selectedTimeInput" value="{{ $selectedTimeId }}">

                <div class="text-center mt-4">
                    <button type="submit" class="continue-btn"
                        {{ !$selectedDate || !$selectedTimeId ? 'disabled' : '' }}>
                        <i class="bi bi-arrow-right me-2"></i>
                        Lanjut ke Pendaftaran
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="/" class="back-link">
                    <i class="bi bi-arrow-left me-1"></i>
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Store current date and selected date for comparison
        const currentDate = '{{ $currentDate ?? '' }}';
        const selectedDate = '{{ $selectedDate ?? '' }}';
        const isToday = selectedDate === currentDate;

        // Function to check if a time has passed
        function isTimePassed(timeString) {
            if (!isToday) return false;

            const now = new Date();
            const currentHour = now.getHours();
            const currentMinute = now.getMinutes();

            const timeParts = timeString.split(':');
            const timeHour = parseInt(timeParts[0]);
            const timeMinute = parseInt(timeParts[1]);

            return (timeHour < currentHour) || (timeHour === currentHour && timeMinute <= currentMinute);
        }

        // Function to update time slots based on current time
        function updateTimeSlots() {
            if (!isToday) return;

            const timeSlots = document.querySelectorAll('.time-slot');
            let hasSelectableTime = false;

            timeSlots.forEach(slot => {
                const timeString = slot.getAttribute('data-time');
                const timeId = slot.getAttribute('data-time-id');
                const canSelect = slot.getAttribute('data-can-select') === 'true';

                if (timeString && isTimePassed(timeString)) {
                    // Mark as past time
                    slot.classList.add('past-time', 'disabled');
                    slot.classList.remove('selected');
                    slot.removeAttribute('onclick');
                    slot.setAttribute('data-can-select', 'false');

                    // Update the indicator text
                    const indicator = slot.querySelector('.remaining-info, .past-time-indicator');
                    if (indicator && !indicator.classList.contains('past-time-indicator')) {
                        indicator.innerHTML = '<div class="past-time-indicator">Waktu sudah lewat</div>';
                        indicator.className = 'past-time-indicator';
                    }

                    // If this was the selected time, clear selection
                    if (slot.classList.contains('selected')) {
                        document.getElementById('selectedTimeInput').value = '';
                        updateContinueButton();
                    }
                } else if (canSelect) {
                    hasSelectableTime = true;
                }
            });

            // Show warning if no selectable times remain
            const existingWarning = document.querySelector('#timeWarning');
            const timeContainer = document.querySelector('.time-container');

            if (!hasSelectableTime && isToday && document.querySelectorAll('.time-slot').length > 0) {
                if (!existingWarning) {
                    const warning = document.createElement('div');
                    warning.id = 'timeWarning';
                    warning.className = 'alert alert-warning mt-3';
                    warning.innerHTML =
                        '<i class="bi bi-exclamation-triangle me-2"></i>Semua jam untuk hari ini sudah lewat atau penuh. Silakan pilih tanggal lain.';
                    timeContainer.appendChild(warning);
                }
            } else if (existingWarning && hasSelectableTime) {
                existingWarning.remove();
            }
        }

        // Function to update current time display
        function updateCurrentTime() {
            const now = new Date();

            // Format date in Indonesian (shorter version for mini display)
            const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ];

            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];

            const dateString = `${dayName}, ${day} ${month}`;

            // Format time
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const timeString = `${hours}:${minutes}:${seconds}`;

            // Update DOM elements
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('currentTime').textContent = timeString;

            // Update time slots every minute (when seconds is 0)
            if (seconds === '00') {
                updateTimeSlots();
            }
        }

        // Function to update continue button state
        function updateContinueButton() {
            const selectedDate = document.getElementById('selectedDateInput').value;
            const selectedTime = document.getElementById('selectedTimeInput').value;
            const continueBtn = document.querySelector('.continue-btn');

            continueBtn.disabled = !selectedDate || !selectedTime;
        }

        // Update time immediately and then every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);

        // Initial check for time slots
        updateTimeSlots();

        // Function to select date
        function selectDate(date) {
            // Update URL to reload page with selected date
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('date', date);
            window.location.search = urlParams.toString();
        }

        // Function to select time
        function selectTime(timeId) {
            // Check if the clicked element is disabled
            const clickedElement = event.target.closest('.time-slot');
            if (clickedElement.classList.contains('disabled') ||
                clickedElement.classList.contains('past-time') ||
                clickedElement.getAttribute('data-can-select') === 'false') {
                return; // Do nothing if disabled
            }

            // Remove previous selections
            document.querySelectorAll('.time-slot.selected').forEach(el => {
                el.classList.remove('selected');
            });

            // Add selection to clicked element
            clickedElement.classList.add('selected');

            // Update hidden input and enable continue button
            document.getElementById('selectedTimeInput').value = timeId;
            updateContinueButton();
        }

        // Auto-refresh page every 10 minutes to update available times and sync with server
        setTimeout(function() {
            if (window.location.search.includes('date=')) {
                window.location.reload();
            }
        }, 600000); // 10 minutes
    </script>
</body>

</html>
