@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Statistik dan ringkasan data SMPN 19 Makassar')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Siswa -->
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Siswa</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $totalSiswa }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center text-xl shadow-inner border border-sky-100">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-green-500 font-semibold">
            <i class="fa-solid fa-circle-check mr-1.5"></i>
            <span>Aktif di sistem</span>
        </div>
    </x-card>

    <!-- Total Guru -->
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Guru</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $totalGuru }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl shadow-inner border border-indigo-100">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-indigo-500 font-semibold">
            <i class="fa-solid fa-shield-halved mr-1.5"></i>
            <span>Telah tersertifikasi</span>
        </div>
    </x-card>

    <!-- Total Kelas -->
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kelas</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $totalKelas }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl shadow-inner border border-emerald-100">
                <i class="fa-solid fa-school"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-emerald-500 font-semibold">
            <i class="fa-solid fa-circle-dot mr-1.5"></i>
            <span>Kelas aktif belajar</span>
        </div>
    </x-card>

    <!-- Presensi Hari Ini -->
    <x-card>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kehadiran Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-850 mt-1">{{ $presensiHariIni }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl shadow-inner border border-rose-100">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>
        <div class="mt-4 flex items-center text-xs text-rose-500 font-semibold">
            <i class="fa-solid fa-clock mr-1.5"></i>
            <span>Perpustakaan & Kelas</span>
        </div>
    </x-card>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart Donut Kehadiran Hari Ini -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Status Presensi Hari Ini</h3>
        <div class="relative flex justify-center items-center h-64">
            <canvas id="todayAttendanceChart"></canvas>
        </div>
        <div class="mt-4 grid grid-cols-2 gap-4 text-center">
            <div class="bg-slate-50 p-2 rounded-xl border border-gray-100">
                <p class="text-xs text-gray-400 font-semibold">Hadir</p>
                <p class="text-sm font-extrabold text-emerald-500">{{ $hadir }}</p>
            </div>
            <div class="bg-slate-50 p-2 rounded-xl border border-gray-100">
                <p class="text-xs text-gray-400 font-semibold">Izin</p>
                <p class="text-sm font-extrabold text-blue-500">{{ $izin }}</p>
            </div>
            <div class="bg-slate-50 p-2 rounded-xl border border-gray-100">
                <p class="text-xs text-gray-400 font-semibold">Sakit</p>
                <p class="text-sm font-extrabold text-amber-500">{{ $sakit }}</p>
            </div>
            <div class="bg-slate-50 p-2 rounded-xl border border-gray-100">
                <p class="text-xs text-gray-400 font-semibold">Alpha</p>
                <p class="text-sm font-extrabold text-rose-500">{{ $alpha }}</p>
            </div>
        </div>
    </div>

    <!-- Chart Line Tren Kehadiran -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Tren Kehadiran (7 Hari Terakhir)</h3>
        <div class="h-80">
            <canvas id="attendanceTrendChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Donut Chart
        const todayCtx = document.getElementById('todayAttendanceChart').getContext('2d');
        new Chart(todayCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
                datasets: [{
                    data: [{{ $hadir }}, {{ $izin }}, {{ $sakit }}, {{ $alpha }}],
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            font: { family: 'Plus Jakarta Sans', size: 11, weight: '500' }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // 2. Line Chart
        const trendCtx = document.getElementById('attendanceTrendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($pastDays) !!},
                datasets: [{
                    label: 'Siswa Hadir',
                    data: {!! json_encode($attendanceTrend) !!},
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#0ea5e9',
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 10 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 10 }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
