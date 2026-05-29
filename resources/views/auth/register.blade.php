@extends('layouts.app')

@section('content')
<main class="flex-grow flex items-center justify-center p-6 relative">
    <div class="absolute top-10 left-10 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-blue-200 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>

    <div class="max-w-5xl w-full flex flex-col md:flex-row items-center gap-12 z-10">
        <!-- Left Illustration -->
        <div class="md:w-1/2 text-center">
            <img src="https://placehold.co/400x400/eef2ff/004de6?text=Ayo+Bergabung!" alt="Ilmuwan Cilik" class="rounded-2xl shadow-xl border-4 border-white mb-6 mx-auto">
            <h2 class="text-2xl font-bold text-brand mb-2">Ayo Bergabung, Ilmuwan Cilik!</h2>
            <p class="text-gray-600">Siapkan kacamata labmu dan mari kita mulai petualangan sains yang seru dan aman.</p>
        </div>
        
        <!-- Right Form -->
        <div class="md:w-1/2 w-full">
            <div class="glass-card p-8 bg-white shadow-xl rounded-3xl border border-gray-200">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-brand">Buat Akun Baru</h3>
                    <p class="text-sm text-gray-500">Mulai petualangan belajarmu hari ini!</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Panggilan</label>
                        <div class="relative">
                            <i class="fa-regular fa-face-smile absolute left-4 top-3 text-gray-400"></i>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="Nama yang muncul di dashboard" required autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <i class="fa-regular fa-envelope absolute left-4 top-3 text-gray-400"></i>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="contoh@mail.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                            <div class="relative">
                                <i class="fa-solid fa-lock absolute left-3 top-3 text-gray-400"></i>
                                <input id="password" name="password" type="password" class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi</label>
                            <div class="relative">
                                <i class="fa-solid fa-clock-rotate-left absolute left-3 top-3 text-gray-400"></i>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full border border-gray-300 rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand" placeholder="••••••••" required autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 flex items-start">
                        <input type="checkbox" id="terms" class="mt-1 mr-2 text-brand border-gray-300 rounded focus:ring-brand">
                        <label for="terms" class="text-xs text-gray-600">Saya menyetujui <a href="#" class="text-brand hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-brand hover:underline">Kebijakan Privasi</a> SafeLab Kids.</label>
                    </div>

                    <button type="submit" class="w-full bg-brand text-white font-bold py-3 rounded-lg hover:bg-brandHover transition shadow-md mb-4">Daftar Sekarang <i class="fa-solid fa-rocket"></i></button>

                    <p class="text-center text-sm text-gray-600">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand font-bold hover:underline">Masuk</a></p>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
