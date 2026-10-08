<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Rincón del Vinilo - Algeciras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FBF9F6] text-[#111111] font-sans antialiased min-h-screen flex flex-col selection:bg-[#C49A5C] selection:text-white">
    
    <header class="w-full bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('intro') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo.jpg') }}" alt="El Rincón del Vinilo" class="h-16 mix-blend-multiply group-hover:scale-105 transition-transform duration-500">
            </a>
            
            <div>
                @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                <a href="{{ route('cart.index') }}" class="flex items-center gap-2 text-[#111111] hover:text-[#C49A5C] transition-colors font-bold uppercase text-sm tracking-widest">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    @if($cartCount > 0)
                        <span class="bg-[#C49A5C] text-white px-2 py-0.5 rounded-full text-xs">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-[#111111] text-[#FBF9F6] text-center py-10 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col items-center justify-center gap-4">
            <img src="{{ asset('images/logo.jpg') }}" alt="El Rincón del Vinilo" class="h-12 brightness-0 invert opacity-80">
            <p class="text-sm tracking-widest uppercase text-[#C49A5C] font-bold">Tienda de Discos &bull; Algeciras</p>
            <p class="text-xs text-gray-500 tracking-wider">&copy; {{ date('Y') }} Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
