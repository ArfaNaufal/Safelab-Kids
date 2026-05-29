@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 flex-grow">
    <div class="bg-accentLight rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-brand mb-2">Pilih Petualangan Sainsmu!</h1>
            <p class="text-gray-600">Temukan eksperimen seru yang bisa kamu lakukan di rumah.</p>
        </div>
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center text-3xl text-purple-600">
            <i class="fa-solid fa-rocket"></i>
        </div>
    </div>

    <form action="{{ route('catalog') }}" method="GET" class="mb-8">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="relative flex-grow">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-white bg-brand p-1.5 rounded-full text-xs"></i>
                <input type="text" name="q" value="{{ old('q', $search ?? '') }}" class="w-full border border-gray-200 rounded-full pl-12 pr-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-brand" placeholder="Cari eksperimen...">
            </div>
            <button type="submit" class="bg-brand text-white px-6 py-3 rounded-full font-semibold hover:bg-brandHover transition">Cari</button>
        </div>

        <div class="mt-4 flex flex-wrap gap-2 items-center">
            @foreach($categories as $category)
                <a href="{{ route('catalog', array_merge(request()->except('page'), ['category' => $category, 'difficulty' => $selectedDifficulty ?? '', 'q' => $search ?? ''])) }}" class="{{ $selectedCategory === $category ? 'bg-brand text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }} px-4 py-2 rounded-full text-sm font-semibold transition">{{ $category }}</a>
            @endforeach
            @foreach($difficulties as $difficulty)
                <a href="{{ route('catalog', array_merge(request()->except('page'), ['difficulty' => $difficulty, 'category' => $selectedCategory ?? '', 'q' => $search ?? ''])) }}" class="{{ $selectedDifficulty === $difficulty ? 'bg-purple-600 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }} px-4 py-2 rounded-full text-sm font-semibold transition">{{ $difficulty }}</a>
            @endforeach
            <span class="ml-auto text-sm text-gray-500">{{ $experiments->count() }} eksperimen ditemukan</span>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        @forelse($experiments as $experiment)
            <div class="glass-card overflow-hidden border border-gray-100 flex flex-col shadow-sm hover:shadow-md transition">
                <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-500 flex flex-col justify-between p-4 text-white relative">
                    <div class="flex items-center justify-between gap-2 text-xs font-semibold">
                        <span class="bg-white/20 px-3 py-1 rounded-full">{{ $experiment->category }}</span>
                        <span class="bg-white/20 px-3 py-1 rounded-full">{{ $experiment->difficulty }}</span>
                    </div>
                    <div class="self-end bg-white/20 px-2 py-1 rounded-full text-[10px]">{{ $experiment->duration_minutes }} Menit</div>
                </div>
                <div class="p-5 flex-grow flex flex-col">
                    <h3 class="font-bold text-xl mb-2 text-gray-900">{{ $experiment->title }}</h3>
                    <p class="text-sm text-gray-500 mb-4 flex-grow">{{ Str::limit($experiment->description, 100) }}</p>
                    @php
                        $progress = $progressMap[$experiment->id] ?? null;
                        $stepCount = count($experiment->simulation_data['steps'] ?? []);
                        $percent = 0;

                        if ($progress) {
                            if ($progress->status === 'completed') {
                                $percent = 100;
                            } elseif ($stepCount > 1) {
                                $percent = round((max(0, $progress->current_step - 1) / max(1, $stepCount - 1)) * 100);
                            }
                        }
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-2 overflow-hidden">
                        <div class="bg-green-400 h-2 rounded-full transition-all" style="width: {{ $percent }}%"></div>
                    </div>
                    <p class="text-xs font-semibold text-gray-600 mb-4">Progress: {{ $percent }}%</p>
                    <a href="{{ route('simulation', $experiment->id) }}" class="block w-full bg-brand text-white text-center font-bold py-2.5 rounded-lg hover:bg-brandHover transition">{{ $percent === 100 ? 'Ulangi' : 'Mulai!' }}</a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">Tidak ada eksperimen yang cocok dengan filter saat ini.</div>
        @endforelse
    </div>
</div>
@endsection
