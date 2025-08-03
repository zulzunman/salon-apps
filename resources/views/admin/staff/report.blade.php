@extends('layouts.app')

@section('title', 'Data Report')

@section('content')
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-chart-pie me-2"></i>Data Report Staff
                </h1>
                <p class="text-muted mb-0">Laporan data registrasi pelanggan per staff</p>
            </div>
        </div>

        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="fas fa-filter me-2"></i>
                    <h6 class="m-0 font-weight-bold">Filter Laporan</h6>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card-body">
                <form method="GET" action="{{ route('staff.reporting') }}" class="mb-4">
                    <div class="row g-3">
                        <!-- Staff Filter -->
                        <div class="col-md-3">
                            <label for="staff_id" class="form-label">
                                <i class="fas fa-user me-1"></i>Pilih Staff
                            </label>
                            <select name="staff_id" id="staff_id" class="form-select">
                                <option value="">Semua Staff</option>
                                @foreach ($staffList as $staff)
                                    <option value="{{ $staff->id }}" {{ $staffId == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- View Type Filter -->
                        <div class="col-md-3">
                            <label for="view_type" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Tampilan
                            </label>
                            <select name="view_type" id="view_type" class="form-select" onchange="toggleFilters()">
                                <option value="daily" {{ $viewType == 'daily' ? 'selected' : '' }}>Per Hari</option>
                                <option value="weekly" {{ $viewType == 'weekly' ? 'selected' : '' }}>Per Minggu</option>
                                <option value="monthly" {{ $viewType == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                            </select>
                        </div>

                        <!-- Year Filter -->
                        <div class="col-md-2">
                            <label for="selected_year" class="form-label">
                                <i class="fas fa-calendar me-1"></i>Tahun
                            </label>
                            <select name="selected_year" id="selected_year" class="form-select"
                                onchange="updateDaysInMonth()">
                                @foreach ($yearOptions as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Month Filter -->
                        <div class="col-md-2" id="month_filter">
                            <label for="selected_month" class="form-label">
                                <i class="fas fa-calendar-check me-1"></i>Bulan
                            </label>
                            <select name="selected_month" id="selected_month" class="form-select"
                                onchange="updateDaysInMonth()">
                                @foreach ($monthOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Filter (hanya untuk daily view) -->
                        <div class="col-md-2" id="date_filter" style="{{ $viewType != 'daily' ? 'display: none;' : '' }}">
                            <label for="selected_date" class="form-label">
                                <i class="fas fa-calendar-day me-1"></i>Tanggal
                            </label>
                            <select name="selected_date" id="selected_date" class="form-select">
                                <option value="">Semua Tanggal</option>
                                @foreach ($dateOptions as $date)
                                    <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                                        {{ $date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('staff.reporting') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Report Results Card -->
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-chart-bar me-2"></i>
                        <h6 class="m-0 font-weight-bold d-inline">Hasil Laporan</h6>
                    </div>
                    <div class="text-end">
                        <small>
                            @if ($viewType === 'daily' && $selectedDate)
                                Tanggal: {{ $selectedDate }}/{{ $selectedMonth }}/{{ $selectedYear }}
                            @elseif($viewType === 'daily')
                                Bulan: {{ $monthOptions[$selectedMonth] }} {{ $selectedYear }}
                            @elseif($viewType === 'weekly')
                                Bulan: {{ $monthOptions[$selectedMonth] }} {{ $selectedYear }}
                            @else
                                Tahun: {{ $selectedYear }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if (count($reportData) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th><i class="fas fa-user me-1"></i>Nama Staff</th>
                                    @if ($viewType === 'daily')
                                        @if ($selectedDate)
                                            <th class="text-center">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ $selectedDate }}/{{ $selectedMonth }}
                                            </th>
                                        @else
                                            @foreach ($dateOptions as $date)
                                                <th class="text-center">{{ $date }}</th>
                                            @endforeach
                                        @endif
                                    @elseif ($viewType === 'weekly')
                                        @php
                                            $daysInMonth = cal_days_in_month(
                                                CAL_GREGORIAN,
                                                $selectedMonth,
                                                $selectedYear,
                                            );
                                            $weekCount = ceil($daysInMonth / 7);
                                        @endphp
                                        @for ($week = 1; $week <= $weekCount; $week++)
                                            @php
                                                $startDay = ($week - 1) * 7 + 1;
                                                $endDay = min($week * 7, $daysInMonth);
                                            @endphp
                                            <th class="text-center">
                                                <small>Minggu {{ $week }}</small><br>
                                                ({{ $startDay }}-{{ $endDay }})
                                            </th>
                                        @endfor
                                    @elseif ($viewType === 'monthly')
                                        @foreach ($monthOptions as $value => $label)
                                            <th class="text-center">{{ $label }}</th>
                                        @endforeach
                                    @endif
                                    <th class="text-center bg-warning">
                                        <i class="fas fa-sum me-1"></i>Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($reportData as $staffId => $data)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <strong>{{ $data['staff_name'] }}</strong>
                                            </div>
                                        </td>

                                        @if ($viewType === 'daily')
                                            @if ($selectedDate)
                                                <td class="text-center">
                                                    <span class="badge bg-info fs-6">
                                                        {{ $data['data'][$selectedDate] ?? 0 }}
                                                    </span>
                                                </td>
                                            @else
                                                @foreach ($dateOptions as $date)
                                                    <td class="text-center">
                                                        @php $count = $data['data'][$date] ?? 0; @endphp
                                                        <span
                                                            class="badge {{ $count > 0 ? 'bg-success' : 'bg-light text-dark' }}">
                                                            {{ $count }}
                                                        </span>
                                                    </td>
                                                @endforeach
                                            @endif
                                        @elseif ($viewType === 'weekly')
                                            @for ($week = 1; $week <= $weekCount; $week++)
                                                <td class="text-center">
                                                    @php $count = $data['data'][$week]['count'] ?? 0; @endphp
                                                    <span
                                                        class="badge {{ $count > 0 ? 'bg-success' : 'bg-light text-dark' }}">
                                                        {{ $count }}
                                                    </span>
                                                </td>
                                            @endfor
                                        @elseif ($viewType === 'monthly')
                                            @foreach ($monthOptions as $value => $label)
                                                <td class="text-center">
                                                    @php $count = $data['data'][$value] ?? 0; @endphp
                                                    <span
                                                        class="badge {{ $count > 0 ? 'bg-success' : 'bg-light text-dark' }}">
                                                        {{ $count }}
                                                    </span>
                                                </td>
                                            @endforeach
                                        @endif

                                        <td class="text-center">
                                            <span class="badge bg-warning text-dark fs-6 fw-bold">
                                                {{ $data['total'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Summary Row -->
                                <tr class="table-info fw-bold">
                                    <td colspan="2" class="text-center">
                                        <i class="fas fa-calculator me-1"></i>TOTAL KESELURUHAN
                                    </td>
                                    @if ($viewType === 'daily')
                                        @if ($selectedDate)
                                            <td class="text-center">
                                                {{ collect($reportData)->sum(function ($item) use ($selectedDate) {return $item['data'][$selectedDate] ?? 0;}) }}
                                            </td>
                                        @else
                                            @foreach ($dateOptions as $date)
                                                <td class="text-center">
                                                    {{ collect($reportData)->sum(function ($item) use ($date) {return $item['data'][$date] ?? 0;}) }}
                                                </td>
                                            @endforeach
                                        @endif
                                    @elseif ($viewType === 'weekly')
                                        @for ($week = 1; $week <= $weekCount; $week++)
                                            <td class="text-center">
                                                {{ collect($reportData)->sum(function ($item) use ($week) {return $item['data'][$week]['count'] ?? 0;}) }}
                                            </td>
                                        @endfor
                                    @elseif ($viewType === 'monthly')
                                        @foreach ($monthOptions as $value => $label)
                                            <td class="text-center">
                                                {{ collect($reportData)->sum(function ($item) use ($value) {return $item['data'][$value] ?? 0;}) }}
                                            </td>
                                        @endforeach
                                    @endif
                                    <td class="text-center bg-danger text-white">
                                        {{ collect($reportData)->sum('total') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-chart-line fa-3x text-muted"></i>
                        </div>
                        <h5 class="text-muted">Tidak ada data tersedia</h5>
                        <p class="text-muted">Tidak ada data report untuk filter yang dipilih.</p>
                        <a href="{{ route('staff.reporting') }}" class="btn btn-primary">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }

        .table th {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .badge {
            min-width: 40px;
            padding: 6px 10px;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .table-responsive {
            border-radius: 0.375rem;
        }
    </style>

    <script>
        function toggleFilters() {
            const viewType = document.getElementById('view_type').value;
            const dateFilter = document.getElementById('date_filter');
            const monthFilter = document.getElementById('month_filter');

            if (viewType === 'daily') {
                dateFilter.style.display = 'block';
                monthFilter.style.display = 'block';
            } else if (viewType === 'weekly') {
                dateFilter.style.display = 'none';
                monthFilter.style.display = 'block';
            } else if (viewType === 'monthly') {
                dateFilter.style.display = 'none';
                monthFilter.style.display = 'block';
            }
        }

        function updateDaysInMonth() {
            const year = document.getElementById('selected_year').value;
            const month = document.getElementById('selected_month').value;
            const dateSelect = document.getElementById('selected_date');

            // Clear existing options
            dateSelect.innerHTML = '<option value="">Semua Tanggal</option>';

            // Get days in month
            const daysInMonth = new Date(year, month, 0).getDate();

            // Add new options
            for (let i = 1; i <= daysInMonth; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.textContent = i;
                dateSelect.appendChild(option);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleFilters();
            updateDaysInMonth();
        });
    </script>
@endsection
