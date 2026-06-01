@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="mb-8">
        <a href="{{ route('admin.experiments.questions.index', $experiment) }}" class="inline-flex items-center text-sm font-semibold text-brand hover:text-brandHover">&larr; Kembali ke daftar pertanyaan</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Pertanyaan untuk {{ $experiment->title }}</h1>
        <p class="mt-2 text-gray-600">Tambahkan satu pertanyaan kuis lengkap dengan jawaban dan pilihan yang benar.</p>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-red-50 border border-red-200 p-4 text-red-700">
                <p class="font-semibold">Terdapat beberapa kesalahan pada input Anda:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.experiments.questions.store', $experiment) }}" method="POST" class="mt-8 space-y-6">
            @csrf

            @include('admin.questions.partials.form', ['question' => null])

            <div class="flex justify-end">
                <button type="submit" class="rounded-full bg-brand px-8 py-3 text-white font-semibold hover:bg-brandHover">Simpan Pertanyaan</button>
            </div>
        </form>
    </div>
</div>
@endsection
