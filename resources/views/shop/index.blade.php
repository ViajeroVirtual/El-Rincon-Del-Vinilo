@extends('layouts.app')

@section('content')
    <div class="mb-16 mt-4 flex flex-col items-center justify-center text-center">
        @if(!request('search'))
            <h2 class="text-4xl md:text-5xl font-black text-[#111111] tracking-tight mb-8 uppercase">
                Catálogo de Vinilos
            </h2>
        @else
            <h2 class="text-3xl md:text-4xl font-black text-[#111111] mb-8 uppercase">
                Resultados para <span class="text-[#C49A5C]">"{{ request('search') }}"</span>
            </h2>
        @endif
        
        <form action="{{ route('tienda') }}" method="GET" class="w-full max-w-2xl flex bg-white rounded-full shadow-md hover:shadow-lg transition-shadow border border-gray-200 overflow-hidden">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por artista o título..." class="w-full px-8 py-4 text-lg border-none focus:outline-none focus:ring-0 bg-transparent text-[#111111] placeholder-gray-400">
            <button type="submit" class="bg-[#111111] hover:bg-[#C49A5C] text-white px-8 md:px-10 transition-colors font-bold uppercase tracking-widest text-sm flex items-center justify-center">
                Buscar
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-10 p-4 bg-[#C49A5C]/10 text-[#C49A5C] font-bold uppercase tracking-wider text-sm rounded-xl border border-[#C49A5C]/30 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-10 p-4 bg-red-50 text-red-600 font-bold uppercase tracking-wider text-sm rounded-xl border border-red-100 text-center">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($novedades) && count($novedades) > 0)
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="h-px bg-gray-200 flex-grow"></div>
                <h3 class="text-2xl font-black text-[#111111] uppercase tracking-widest text-center">Novedades</h3>
                <div class="h-px bg-gray-200 flex-grow"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($novedades as $product)
                    @include('shop.partials.product', ['product' => $product])
                @endforeach
            </div>
        </div>
    @endif

    @if(isset($recomendados) && count($recomendados) > 0)
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-8">
                <div class="h-px bg-gray-200 flex-grow"></div>
                <h3 class="text-2xl font-black text-[#111111] uppercase tracking-widest text-center">Selección {{ $regionName }}</h3>
                <div class="h-px bg-gray-200 flex-grow"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($recomendados as $product)
                    @include('shop.partials.product', ['product' => $product])
                @endforeach
            </div>
        </div>
    @endif

    <div class="mb-12">
        <div class="flex items-center gap-4 mb-10">
            <h3 class="text-2xl font-black text-[#111111] uppercase tracking-widest">Archivo Completo</h3>
            <div class="h-px bg-gray-200 flex-grow"></div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach($products as $product)
                @include('shop.partials.product', ['product' => $product])
            @endforeach
        </div>
    </div>

    <div class="mt-16">
        {{ $products->links() }}
    </div>
@endsection
