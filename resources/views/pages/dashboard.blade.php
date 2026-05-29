@extends('layouts.app')

@section('content')
<main class="max-w-6xl mx-auto px-4 py-8 flex-grow">
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between mb-8 shadow-sm relative overflow-hidden">
        <div class="z-10">
            <h1 class="text-4xl font-bold text-brand mb-2">Halo, {{ $user->name }}!<br>Pantau Progres Si Kecil</h1>
            <p class="text-gray-600 max-w-lg mt-3">Lihat perkembangan belajar si kecil hari ini. Dukung terus rasa ingin tahunya di SafeLab!</p>
        </div>
        <div class="z-10 mt-6 md:mt-0">
            <img src="https://placehold.co/120x120/004de6/ffffff?text=pict" class="rounded-full w-28 h-28 border-4 border-white shadow-lg object-cover" alt="Ayah">
        </div>
        <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-blue-100 to-transparent opacity-50"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass-card p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -z-10"></div>
            <div class="w-12 h-12 bg-brand text-white rounded-full flex items-center justify-center text-xl"><i class="fa-solid fa-flask"></i></div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Total Eksperimen</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-brand">{{ $completedCount }}</span>
                    <span class="text-sm text-gray-500">Selesai</span>
                </div>
            </div>
        </div>
        <div class="glass-card p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -z-10"></div>
            <div class="w-12 h-12 bg-green-400 text-white rounded-full flex items-center justify-center text-xl"><i class="fa-solid fa-medal"></i></div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Lencana Diraih</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-green-600">{{ $badgeCount }}</span>
                    <span class="text-sm text-gray-500">Lencana</span>
                </div>
            </div>
        </div>
        <div class="glass-card p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-bl-full -z-10"></div>
            <div class="w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center text-xl"><i class="fa-solid fa-microscope"></i></div>
            <div>
                <p class="text-sm text-gray-500 font-semibold">Materi Favorit</p>
                <p class="text-2xl font-bold text-purple-700 mt-1">{{ $favoriteTopic }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-brand mb-4 flex items-center gap-2"><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas Terbaru</h3>
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-lg"><i class="fa-solid fa-bolt"></i></div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $activity->experiment->title }} {{ $activity->status === 'completed' ? 'telah selesai' : ' sedang berjalan' }}.</p>
                                    <p class="text-xs text-gray-500">{{ $activity->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if($activity->status === 'completed')
                                <a href="{{ route('simulation', $activity->experiment->id) }}" class="bg-brand text-white text-sm px-4 py-1.5 rounded-lg font-bold">Lihat Hasil</a>
                            @endif
                        </div>
                    @empty
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-gray-500">Belum ada aktivitas terbaru. Ajak Si Kecil mulai eksperimen!</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-100 relative overflow-hidden">
                <h3 class="text-xl font-bold text-brand mb-4 flex items-center gap-2"><i class="fa-regular fa-lightbulb"></i> Pojok Orang Tua</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-3">
                        <div class="text-blue-500 mt-1"><i class="fa-solid fa-comment-dots text-xl"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800 mb-1">Tips mendampingi anak belajar sains</h4>
                            <p class="text-xs text-gray-600">Cara seru menjelaskan konsep rumit jadi mudah dipahami.</p>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-3">
                        <div class="text-green-500 mt-1"><i class="fa-solid fa-shield-halved text-xl"></i></div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800 mb-1">Keamanan Lab di Rumah</h4>
                            <p class="text-xs text-gray-600">Bahan rumah tangga aman untuk eksperimen seru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 h-full flex flex-col">
                <h3 class="text-xl font-bold text-brand mb-6 flex items-center gap-2"><i class="fa-solid fa-chart-simple"></i> Grafik Belajar (Minggu Ini)</h3>
                <div class="flex-grow flex items-end justify-between px-2 pb-6 border-b border-gray-200 mt-10 space-x-2">
                    @php
                        $maxWeekly = max($weeklyData) ?: 1;
                    @endphp
                    @foreach($weeklyData as $day => $value)
                        <div class="flex flex-col items-center w-full">
                            <div class="w-8 {{ $value === $maxWeekly ? 'bg-brand' : 'bg-blue-100' }} rounded-t-md" style="height: {{ max(24, $value * 18) }}px;"></div>
                            <span class="text-xs {{ $value === $maxWeekly ? 'font-bold text-brand' : 'text-gray-400' }} mt-2">{{ $day }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <p class="text-sm font-semibold text-gray-700">Total aktivitas minggu ini: <span class="text-brand">{{ array_sum($weeklyData) }} sesi</span></p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
