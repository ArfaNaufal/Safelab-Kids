@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Eksperimen</h1>
            <p class="mt-2 text-gray-600">Tambahkan, edit, atau hapus eksperimen untuk SafeLab Kids.</p>
        </div>
        <a href="{{ route('admin.experiments.create') }}" class="inline-flex items-center justify-center rounded-full bg-brand px-6 py-3 text-white font-semibold hover:bg-brandHover">Tambah Eksperimen</a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 mb-6">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kesulitan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Durasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Poin</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($experiments as $experiment)
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ $experiment->title }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $experiment->category }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $experiment->difficulty }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $experiment->duration_minutes }} menit</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $experiment->points_reward }}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium space-x-2">
                            <a href="{{ route('admin.experiments.questions.index', $experiment) }}" class="text-sky-600 hover:text-sky-800">Pertanyaan</a>
                            <a href="{{ route('admin.experiments.edit', $experiment) }}" class="text-brand hover:text-brandHover">Edit</a>
                            <form action="{{ route('admin.experiments.destroy', $experiment) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus eksperimen ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">Belum ada eksperimen. Tambahkan eksperimen terlebih dahulu.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
