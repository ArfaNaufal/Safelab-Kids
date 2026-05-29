@extends('layouts.app')

@section('content')
<main class="flex-grow flex items-center justify-center p-6">
    <div class="max-w-4xl w-full flex flex-col md:flex-row items-center gap-12">
        <!-- Left Illustration -->
        <div class="md:w-1/2 text-center">
            <div class="bg-blue-50 border-2 border-dashed border-blue-200 rounded-3xl p-4 inline-block mb-6">
                <img src="https://placehold.co/300x300/eef2ff/004de6?text=Ilmuwan+Cilik" alt="Ilmuwan Cilik" class="rounded-2xl">
            </div>
            <h2 class="text-2xl font-bold text-brand mb-2">Halo, Ilmuwan Cilik!</h2>
            <p class="text-gray-600">Siap untuk melakukan eksperimen seru hari ini? Yuk, masuk ke laboratorium!</p>
        </div>

        <!-- Right Form -->
        <div class="md:w-1/2 w-full">
            <div class="glass-card p-8 bg-white shadow-lg rounded-3xl border border-gray-200">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Masuk Laboratorium</h3>
                    <p class="text-sm text-gray-500">Masukkan email dan kata sandimu</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope absolute left-4 top-3 text-gray-400"></i>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="contoh@mail.com" required autofocus>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-brand hover:underline">Lupa PIN?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-3 text-gray-400"></i>
                            <input id="password" name="password" type="password" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="••••••••" required autocomplete="current-password">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-green-700 text-white font-bold py-3 rounded-lg hover:bg-green-800 transition shadow-lg mb-6"><i class="fa-solid fa-rocket mr-2"></i> Mulai Belajar!</button>

                    <p class="text-center text-sm text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="text-brand font-bold hover:underline">Daftar Sekarang</a></p>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
