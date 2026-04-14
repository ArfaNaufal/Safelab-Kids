@extends('layouts.app')

@section('content')
<main class="flex-grow">
    <section class="max-w-6xl mx-auto px-4 py-12 flex flex-col md:flex-row items-center gap-8">
        <div class="md:w-1/2">
            <span class="bg-blue-100 text-brand px-3 py-1 rounded-full text-sm font-semibold mb-4 inline-block"><i class="fa-solid fa-flask"></i> Science Lab Digital</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">Eksplorasi Sains Seru & Aman di Rumah!</h1>
            <p class="text-gray-600 mb-8 text-lg">Ubah rasa ingin tahu menjadi penemuan hebat! Belajar sains tanpa batas, dukung pendidikan berkualitas (SDG 4) dengan eksperimen virtual yang 100% aman untuk anak.</p>
            <a href="{{ route('catalog') }}" class="bg-green-600 text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-green-700 transition inline-block"><i class="fa-solid fa-rocket mr-2"></i> Mulai Eksperimen Gratis</a>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <div class="glass-card p-4 relative border-4 border-green-200 bg-white">
                <div class="absolute -top-4 -left-4 bg-green-100 text-green-700 px-3 py-1 rounded-full font-bold text-sm shadow-sm"><i class="fa-solid fa-star"></i> +10 Poin Pintar</div>
                <img src="https://placehold.co/400x300/eef2ff/004de6?text=Ilustrasi+Anak+Sains" alt="Ilustrasi Sains" class="rounded-xl w-full">
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-brand text-white rounded-3xl p-10 text-center shadow-lg">
            <div class="text-4xl mb-4"><i class="fa-solid fa-book-open-reader"></i></div>
            <h2 class="text-2xl font-bold mb-4">Mendukung Pendidikan Berkualitas (SDG 4)</h2>
            <p class="max-w-3xl mx-auto opacity-90 leading-relaxed">Kami percaya setiap anak berhak mendapatkan akses ke pendidikan sains yang menyenangkan dan aman. SafeLab Kids dirancang untuk menghapus batasan fisik lab tradisional, memungkinkan eksplorasi konsep rumit secara visual tanpa risiko bahan kimia nyata.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12 text-center">
        <h2 class="text-3xl font-bold text-brand mb-2">Kenapa SafeLab Kids?</h2>
        <p class="text-gray-500 mb-10">Metode belajar interaktif yang dirancang khusus untuk anak.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card p-8 text-left hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-blue-100 text-brand rounded-lg flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-microscope"></i></div>
                <h3 class="font-bold text-xl mb-2">Simulasi Visual</h3>
                <p class="text-gray-600 text-sm">Eksperimen virtual yang terlihat nyata. Campurkan cairan, nyalakan api, dan lihat reaksi kimianya dengan aman di layar.</p>
            </div>
            <div class="glass-card p-8 text-left hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-blue-100 text-brand rounded-lg flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-clipboard-check"></i></div>
                <h3 class="font-bold text-xl mb-2">Panduan Interaktif</h3>
                <p class="text-gray-600 text-sm">Asisten Lab AI kami membimbing langkah demi langkah, memastikan anak memahami urutan eksperimen dengan benar.</p>
            </div>
            <div class="glass-card p-8 text-left hover:-translate-y-1 transition">
                <div class="w-12 h-12 bg-blue-100 text-brand rounded-lg flex items-center justify-center text-xl mb-4"><i class="fa-solid fa-comment-dots"></i></div>
                <h3 class="font-bold text-xl mb-2">Bahasa Sederhana</h3>
                <p class="text-gray-600 text-sm">Konsep sains kompleks dijelaskan dengan analogi sehari-hari yang mudah dipahami oleh anak usia 4-12 tahun.</p>
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 py-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-3xl font-bold text-brand mb-2">Eksperimen Populer</h2>
                <p class="text-gray-500">Mulai petualangan sainsmu dari sini!</p>
            </div>
            <a href="{{ route('catalog') }}" class="text-brand font-bold hover:underline">Lihat Semua &rarr;</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($popularExperiments as $experiment)
                <div class="glass-card overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition">
                    <div class="h-40 bg-gradient-to-br from-blue-500 to-indigo-500 flex items-end p-4 text-white">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">{{ $experiment->difficulty }}</span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded">{{ $experiment->category }}</span>
                        <h3 class="font-bold text-xl mt-3 mb-2 text-gray-900">{{ $experiment->title }}</h3>
                        <p class="text-gray-500 text-sm mb-4">{{ Str::limit($experiment->description, 110) }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                            <span><i class="fa-solid fa-clock mr-1"></i> {{ $experiment->duration_minutes }} Menit</span>
                            <span><i class="fa-solid fa-award mr-1"></i> {{ $experiment->points_reward }} Poin</span>
                        </div>
                        <a href="{{ route('simulation', $experiment->id) }}" class="block text-center bg-blue-100 text-brand font-bold py-2 rounded hover:bg-blue-200">Coba Sekarang</a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Belum ada eksperimen tersedia saat ini.</div>
            @endforelse
        </div>
    </section>
</main>
@endsection
