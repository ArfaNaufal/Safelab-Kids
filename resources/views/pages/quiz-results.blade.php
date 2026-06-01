@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 flex-grow">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-brand mb-2">Hasil Kuis Anda</h1>
        <p class="text-gray-600">Eksperimen: {{ $experiment->title }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-green-400 to-emerald-500 rounded-3xl p-8 text-white shadow-lg text-center">
            <p class="text-sm uppercase tracking-widest font-semibold opacity-90 mb-2">Skor Akhir</p>
            <p class="text-6xl font-bold">{{ $result->score }}%</p>
        </div>

        <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-3xl p-8 text-white shadow-lg text-center">
            <p class="text-sm uppercase tracking-widest font-semibold opacity-90 mb-2">Jawaban Benar</p>
            <p class="text-6xl font-bold">{{ $result->correct_answers }}/{{ $result->total_questions }}</p>
        </div>

        <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-3xl p-8 text-white shadow-lg text-center">
            <p class="text-sm uppercase tracking-widest font-semibold opacity-90 mb-2">Bonus Poin</p>
            <p class="text-6xl font-bold">{{ round($experiment->points_reward * 0.5 * ($result->score / 100)) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8 mb-8">
        <div class="mb-6">
            @if($result->score >= 80)
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded mb-6">
                    <p class="text-green-700 font-semibold"><i class="fa-solid fa-check-circle mr-2"></i>Luar Biasa!</p>
                    <p class="text-green-600 text-sm">Anda lulus kuis. Eksperimen ini sekarang selesai dan poin telah diberikan.</p>
                </div>
            @elseif($result->score >= 60)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-6">
                    <p class="text-blue-700 font-semibold"><i class="fa-solid fa-thumbs-up mr-2"></i>Bagus!</p>
                    <p class="text-blue-600 text-sm">Nilai Anda cukup baik, tetapi belum memenuhi batas kelulusan. Silakan ulangi kuis untuk menyelesaikan eksperimen.</p>
                </div>
            @else
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded mb-6">
                    <p class="text-amber-700 font-semibold"><i class="fa-solid fa-info-circle mr-2"></i>Coba Lagi</p>
                    <p class="text-amber-600 text-sm">Nilai Anda di bawah {{ \App\Http\Controllers\Web\PageController::QUIZ_PASSING_SCORE }}%. Eksperimen belum selesai, pelajari kembali langkah simulasi dan coba lagi.</p>
                </div>
            @endif

            <h3 class="text-xl font-bold mb-4 text-gray-900">Ringkasan Hasil</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Pertanyaan</span>
                    <strong class="text-gray-900">{{ $result->total_questions }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jawaban Benar</span>
                    <strong class="text-green-600">{{ $result->correct_answers }}</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Jawaban Salah</span>
                    <strong class="text-red-600">{{ $result->total_questions - $result->correct_answers }}</strong>
                </div>
                <div class="border-t border-gray-200 pt-3 mt-3 flex justify-between">
                    <span class="text-gray-600">Persentase</span>
                    <strong class="text-brand">{{ $result->score }}%</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('simulation', $experiment->id) }}" class="w-full sm:w-auto text-center bg-brand text-white px-8 py-3 rounded-full font-semibold hover:bg-brandHover transition">
            <i class="fa-solid fa-repeat mr-2"></i>Ulangi Kuis
        </a>
        <a href="{{ route('catalog') }}" class="w-full sm:w-auto text-center border-2 border-brand text-brand px-8 py-3 rounded-full font-semibold hover:bg-brand/5 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Katalog
        </a>
        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto text-center border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-50 transition">
            <i class="fa-solid fa-chart-line mr-2"></i>Lihat Dashboard
        </a>
    </div>
</div>
@endsection
