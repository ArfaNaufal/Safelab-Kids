@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 flex-grow">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-brand">{{ $experiment->title }}</h1>
            <p class="text-gray-600">{{ $experiment->category }} • {{ $experiment->difficulty }} • {{ $experiment->duration_minutes }} Menit</p>
        </div>
        <a href="{{ route('catalog') }}" class="bg-brand text-white px-5 py-2 rounded-full font-semibold hover:bg-brandHover transition">Kembali ke Catalog</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <section class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
            <div class="mb-6">
                <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.2em] text-brand bg-blue-50 px-3 py-1 rounded-full">{{ $experiment->category }}</span>
            </div>
            <p class="text-gray-700 leading-relaxed mb-6">{{ $experiment->description }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-slate-50 rounded-2xl p-5">
                    <h3 class="text-sm uppercase tracking-[0.18em] text-gray-500 mb-2">Durasi</h3>
                    <p class="text-xl font-bold">{{ $experiment->duration_minutes }} Menit</p>
                </div>
                <div class="bg-slate-50 rounded-2xl p-5">
                    <h3 class="text-sm uppercase tracking-[0.18em] text-gray-500 mb-2">Poin</h3>
                    <p class="text-xl font-bold">{{ $experiment->points_reward }} Poin</p>
                </div>
            </div>

            <div id="simulationApp" class="space-y-8">
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <p class="text-sm uppercase tracking-[0.2em] text-brand font-semibold">Simulasi Interaktif</p>
                            <h2 class="text-2xl font-bold text-slate-900">Ikuti langkah demi langkah</h2>
                        </div>
                        <span id="statusLabel" class="inline-flex items-center px-3 py-2 rounded-full bg-brand/10 text-brand font-semibold">{{ $progressStatus === 'completed' ? 'Selesai' : ($progressStatus === 'quiz_pending' ? 'Menunggu Kuis' : ($progressStatus === 'started' ? 'Berjalan' : 'Belum Dimulai')) }}</span>
                    </div>

                    <div class="h-3 bg-white border border-slate-200 rounded-full overflow-hidden mb-3">
                        <div id="progressBar" class="h-full bg-brand transition-all" style="width: {{ $progressStatus === 'completed' ? 100 : intval(($currentStep - 1) / max(1, $totalSteps - 1) * 100) }}%"></div>
                    </div>
                    <p class="text-sm text-gray-500">Langkah <span id="currentStepIndex">{{ $currentStep }}</span> dari <span id="maxSteps">{{ $totalSteps }}</span></p>

                    <div class="mt-6 bg-white rounded-3xl p-6 border border-slate-200">
                        <h3 class="text-lg font-semibold mb-3">Langkah Saat Ini</h3>
                        <p id="stepText" class="text-gray-700 leading-relaxed">Memuat langkah simulasi...</p>
                        <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            @auth
                                <div class="flex flex-col sm:flex-row gap-3 w-full">
                                    <button id="nextStepBtn" type="button" class="w-full sm:w-auto bg-brand text-white px-6 py-3 rounded-full font-semibold hover:bg-brandHover transition">Mulai Simulasi</button>
                                    <button id="resetStepBtn" type="button" class="w-full sm:w-auto border border-brand text-brand px-6 py-3 rounded-full font-semibold hover:bg-brand/5 transition hidden">Ulangi Simulasi</button>
                                    <a id="quizBtn" href="{{ route('quiz', $experiment->id) }}" class="w-full sm:w-auto text-center bg-green-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-600 transition hidden">Mulai Kuis</a>
                                </div>
                            @else
                                <a href="{{ url('/login') }}" class="w-full sm:w-auto text-center bg-brand text-white px-6 py-3 rounded-full font-semibold hover:bg-brandHover transition">Masuk untuk Mulai</a>
                            @endauth
                            <p id="resultLabel" class="text-sm text-slate-500"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-bold mb-4">Hasil Yang Diharapkan</h3>
                    <p class="text-gray-700">{{ $experiment->simulation_data['expected_result'] ?? 'Coba selesaikan semua langkah untuk mengetahui hasil eksperimen.' }}</p>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Alat & Bahan</h2>
                @php
                    $tools = is_array($experiment->simulation_data['tools'] ?? null) ? $experiment->simulation_data['tools'] : [];
                @endphp
                @if(count($tools))
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach($tools as $tool)
                            <li>{{ $tool }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Tidak ada daftar alat khusus. Gunakan bahan eksperimen umum sesuai deskripsi.</p>
                @endif
            </div>
        </section>

        <aside class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-xl font-bold mb-3">Ringkasan</h3>
                <div class="space-y-3 text-gray-700 text-sm">
                    <div class="flex justify-between gap-3">
                        <span>Kategori</span>
                        <strong>{{ $experiment->category }}</strong>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span>Tingkat</span>
                        <strong>{{ $experiment->difficulty }}</strong>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span>Durasi</span>
                        <strong>{{ $experiment->duration_minutes }} Menit</strong>
                    </div>
                    <div class="flex justify-between gap-3">
                        <span>Poin</span>
                        <strong>{{ $experiment->points_reward }}</strong>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 text-sm text-gray-700">
                <h4 class="font-semibold mb-3">Tips Aman</h4>
                <p>Pastikan selalu membaca setiap langkah sebelum melanjutkan. Simulasi ini dirancang untuk belajar dan memahami konsep eksperimen dengan aman.</p>
            </div>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const steps = @json(is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : []);
        const totalSteps = {{ $totalSteps }};
        let currentStep = {{ $currentStep }};
        const statusLabel = document.getElementById('statusLabel');
        const progressBar = document.getElementById('progressBar');
        const stepText = document.getElementById('stepText');
        const currentStepIndex = document.getElementById('currentStepIndex');
        const maxSteps = document.getElementById('maxSteps');
        const nextStepBtn = document.getElementById('nextStepBtn');
        const resetStepBtn = document.getElementById('resetStepBtn');
        const quizBtn = document.getElementById('quizBtn');
        const resultLabel = document.getElementById('resultLabel');

        const updateStepUI = () => {
            const stepIndex = Math.min(Math.max(currentStep, 1), totalSteps);
            stepText.textContent = steps[stepIndex - 1] || 'Tidak ada langkah yang tersedia untuk eksperimen ini.';
            currentStepIndex.textContent = stepIndex;
            maxSteps.textContent = totalSteps;
            const percent = totalSteps > 1 ? Math.round(((stepIndex - 1) / (totalSteps - 1)) * 100) : 100;
            progressBar.style.width = `${percent}%`;

            if (stepIndex >= totalSteps) {
                nextStepBtn.textContent = 'Selesaikan Simulasi';
            } else {
                nextStepBtn.textContent = currentStep === 1 ? 'Mulai Simulasi' : 'Langkah Berikutnya';
            }

            if (resetStepBtn) {
                resetStepBtn.classList.toggle('hidden', stepIndex <= 1 && statusLabel.textContent !== 'Selesai' && statusLabel.textContent !== 'Menunggu Kuis');
            }

            if (quizBtn) {
                quizBtn.classList.toggle('hidden', statusLabel.textContent !== 'Selesai' && statusLabel.textContent !== 'Menunggu Kuis');
            }
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const saveProgress = async (status, step) => {
            try {
                const response = await fetch('{{ route('simulation.progress', $experiment->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status, step })
                });
                return await response.json();
            } catch (error) {
                console.error('Error saving progress:', error);
                return null;
            }
        };

        nextStepBtn?.addEventListener('click', async function () {
            if (!steps.length) {
                return;
            }

            if (currentStep >= totalSteps) {
                const result = await saveProgress('completed', totalSteps);
                if (result && result.status === 'success') {
                    currentStep = totalSteps;
                    statusLabel.textContent = 'Menunggu Kuis';
                    resultLabel.textContent = 'Simulasi selesai. Lengkapi kuis untuk menyelesaikan eksperimen.';
                    updateStepUI();
                }
                return;
            }

            const nextStep = currentStep + 1;
            const result = await saveProgress('started', nextStep);
            if (result && result.status === 'success') {
                currentStep = nextStep;
                statusLabel.textContent = 'Berjalan';
                resultLabel.textContent = '';
                updateStepUI();
            }
        });

        resetStepBtn?.addEventListener('click', async function () {
            const result = await saveProgress('reset', 1);
            if (result && result.status === 'success') {
                currentStep = 1;
                statusLabel.textContent = 'Berjalan';
                resultLabel.textContent = 'Simulasi sudah direset. Mulai lagi dari langkah pertama.';
                updateStepUI();
            }
        });

        updateStepUI();
    });
</script>
@endsection
