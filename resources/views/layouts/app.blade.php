<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeLab Kids</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: '#004de6', brandHover: '#003bb3' } } } }
    </script>
</head>
<body class="bg-[#f4f7fe] flex flex-col min-h-screen text-gray-800">
    <nav class="bg-white py-4 px-8 flex justify-between items-center shadow-sm sticky top-0 z-50">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-brand flex items-center gap-2">
            <i class="fa-solid fa-flask"></i> SafeLab Kids
        </a>
        <div class="hidden md:flex gap-8 text-gray-600 font-medium">
            <a href="{{ route('home') }}" class="hover:text-brand {{ request()->routeIs('home') ? 'text-brand font-semibold' : '' }}">Home</a>
            <a href="{{ route('catalog') }}" class="hover:text-brand {{ request()->routeIs('catalog') ? 'text-brand font-semibold' : '' }}">Eksperimen</a>
            <a href="{{ route('dashboard') }}" class="hover:text-brand {{ request()->routeIs('dashboard') ? 'text-brand font-semibold' : '' }}">Dashboard</a>
        </div>
        <div class="relative">
            @auth
                <div class="group inline-block text-left">
                    <button class="inline-flex items-center gap-2 bg-brand text-white px-5 py-2 rounded-full font-semibold focus:outline-none">
                        {{ Auth::user()->name }}
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-44 bg-white rounded-2xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">Edit Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="bg-brand text-white px-6 py-2 rounded-full font-semibold">Masuk</a>
            @endauth
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-brand text-white py-6 text-center mt-auto">
        <p>&copy; 2024 SafeLab Kids - Mendukung SDG 4: Pendidikan Berkualitas</p>
    </footer>
    @stack('scripts')
</body>
</html>
