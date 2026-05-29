@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 flex-grow">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-brand">Kuis: {{ $experiment->title }}</h1>
            <p class="text-gray-600">Uji pemahaman Anda tentang eksperimen ini</p>
        </div>
        <a href="{{ route('catalog') }}" class="bg-brand text-white px-5 py-2 rounded-full font-semibold hover:bg-brandHover transition">Kembali</a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 p-8">
        <div class="mb-8 bg-blue-50 rounded-2xl p-6 border border-blue-200">
            <h2 class="text-xl font-bold text-brand mb-2">Petunjuk</h2>
            <p class="text-gray-700 text-sm">Jawab semua pertanyaan dengan fokus. Anda harus mendapatkan minimal {{ \App\Http\Controllers\Web\PageController::QUIZ_PASSING_SCORE }}% untuk menyelesaikan eksperimen dan mendapatkan poin penuh.</p>
        </div>

        <form action="{{ route('quiz.submit', $experiment->id) }}" method="POST" id="quizForm">
            @csrf

            @forelse($questions as $index => $question)
                <div class="mb-8 pb-8 border-b border-gray-200 last:border-b-0">
                    <div class="flex items-start gap-4 mb-4">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand text-white font-bold flex-shrink-0">{{ $index + 1 }}</span>
                        <h3 class="text-lg font-semibold text-gray-900 flex-grow">{{ $question->question_text }}</h3>
                    </div>

                    <div class="space-y-3 ml-14">
                        @foreach($question->answers as $answer)
                            <label class="flex items-center gap-3 p-3 rounded-lg border-2 border-gray-200 cursor-pointer hover:border-brand hover:bg-blue-50 transition">
                                <input type="radio" name="answer_{{ $question->id }}" value="{{ $answer->id }}" class="w-4 h-4 text-brand cursor-pointer" required>
                                <span class="text-gray-700 flex-grow">{{ $answer->answer_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-12">
                    <p>Tidak ada pertanyaan yang tersedia untuk kuis ini.</p>
                </div>
            @endforelse

            @if(count($questions) > 0)
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="w-full sm:w-auto bg-brand text-white px-8 py-3 rounded-full font-semibold hover:bg-brandHover transition">
                        Selesaikan Kuis
                    </button>
                    <a href="{{ route('simulation', $experiment->id) }}" class="w-full sm:w-auto text-center border-2 border-brand text-brand px-8 py-3 rounded-full font-semibold hover:bg-brand/5 transition">
                        Kembali
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
