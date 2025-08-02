@extends('layouts.app')

@section('title', 'Data Report')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <!-- Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Report</h6>
            </div>

            <!-- Filter Form -->
            <div class="card-body">
                <form method="GET" action="{{ route('staff.reporting') }}" class="mb-4">
                    <div class="row">
                        <!-- Staff Filter -->
                        <div class="col-md-3 mb-3">
                            <label for="staff_id" class="form-label">Pilih Staff</label>
                            <select name="staff_id" id="staff_id" class="form-control">
                                <option value="">Semua Staff</option>
                                @foreach ($staffList as $staff)
                                    <option value="{{ $staff->id }}" {{ $staffId == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- View Type Filter -->
                        <div class="col-md-3 mb-3">
                            <label for="view_type" class="form-label">Tampilan</label>
                            <select name="view_type" id="view_type" class="form-control" onchange="toggleFilters()">
                                <option value="daily" {{ $viewType == 'daily' ? 'selected' : '' }}>Per Hari</option>
                                <option value="weekly" {{ $viewType == 'weekly' ? 'selected' : '' }}>Per Minggu</option>
                                <option value="monthly" {{ $viewType == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                            </select>
                        </div>

                        <!-- Year Filter -->
                        <div class="col-md-2 mb-3">
                            <label for="selected_year" class="form-label">Tahun</label>
                            <select name="selected_year" id="selected_year" class="form-control"
                                onchange="updateDaysInMonth()">
                                @foreach ($yearOptions as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Month Filter -->
                        <div class="col-md-2 mb-3" id="month_filter">
                            <label for="selected_month" class="form-label">Bulan</label>
                            <select name="selected_month" id="selected_month" class="form-control"
                                onchange="updateDaysInMonth()">
                                @foreach ($monthOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedMonth == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Filter (hanya untuk daily view) -->
                        <div class="col-md-2 mb-3" id="date_filter"
                            style="{{ $viewType != 'daily' ? 'display: none;' : '' }}">
                            <label for="selected_date" class="form-label">Tanggal</label>
                            <select name="selected_date" id="selected_date" class="form-control">
                                <option value="">Semua Tanggal</option>
                                @foreach ($dateOptions as $date)
                                    <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                                        {{ $date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('staff.reporting') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Reset
                    </a>
                </form>
            </div>

            <!-- Report Table -->
            <div class="card-body pt-0">
                @if (count($reportData) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Staff</th>
                                    @if ($viewType === 'daily')
                                        @if ($selectedDate)
                                            <th>Tanggal {{ $selectedDate }}</th>
                                        @else
                                            @foreach ($dateOptions as $date)
                                                <th>Tgl {{ $date }}</th>
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
                                            <th>Minggu {{ $week }} ({{ $startDay }}-{{ $endDay }})</th>
                                        @endfor
                                    @elseif ($viewType === 'monthly')
                                        @foreach ($monthOptions as $value => $label)
                                            <th>{{ $label }}</th>
                                        @endforeach
                                    @endif
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($reportData as $staffId => $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data['staff_name'] }}</td>

                                        @if ($viewType === 'daily')
                                            @if ($selectedDate)
                                                <td class="text-center">
                                                    {{ $data['data'][$selectedDate] ?? 0 }}
                                                </td>
                                            @else
                                                @foreach ($dateOptions as $date)
                                                    <td class="text-center">
                                                        {{ $data['data'][$date] ?? 0 }}
                                                    </td>
                                                @endforeach
                                            @endif
                                        @elseif ($viewType === 'weekly')
                                            @for ($week = 1; $week <= $weekCount; $week++)
                                                <td class="text-center">
                                                    {{ $data['data'][$week]['count'] ?? 0 }}
                                                </td>
                                            @endfor
                                        @elseif ($viewType === 'monthly')
                                            @foreach ($monthOptions as $value => $label)
                                                <td class="text-center">
                                                    {{ $data['data'][$value] ?? 0 }}
                                                </td>
                                            @endforeach
                                        @endif

                                        <td class="text-center font-weight-bold">
                                            {{ $data['total'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Tidak ada data report tersedia untuk filter yang dipilih.
                    </div>
                @endif
            </div>
        </div>
    </div>

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
