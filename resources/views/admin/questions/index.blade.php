@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pertanyaan Kuis untuk {{ $experiment->title }}</h1>
            <p class="mt-2 text-gray-600">Kelola soal dan pilihan jawaban untuk eksperimen ini.</p>
        </div>
        <a href="{{ route('admin.experiments.questions.create', $experiment) }}" class="inline-flex items-center justify-center rounded-full bg-brand px-6 py-3 text-white font-semibold hover:bg-brandHover">Tambah Pertanyaan</a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 mb-6">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Pertanyaan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Jawaban</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($questions as $question)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $question->question_text }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @foreach($question->answers as $answer)
                                <div class="mb-2">
                                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-xs {{ $answer->is_correct ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-gray-200 bg-gray-50 text-gray-600' }}">
                                        {{ $answer->answer_text }}
                                        @if($answer->is_correct)
                                            · Benar
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.experiments.questions.edit', [$experiment, $question]) }}" class="text-brand hover:text-brandHover">Edit</a>
                            <form action="{{ route('admin.experiments.questions.destroy', [$experiment, $question]) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pertanyaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada pertanyaan untuk eksperimen ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
