@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <a href="{{ route('tienda') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#C49A5C] font-bold uppercase tracking-widest text-xs transition-colors group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al catálogo
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden flex flex-col md:flex-row relative z-10 mb-16">
        
        <!-- Imagen y Disco -->
        <div class="w-full md:w-1/2 bg-[#FBF9F6] flex items-center justify-center p-8 md:p-16 relative border-r border-gray-100 group cursor-pointer overflow-visible">
            
            <div class="relative w-full max-w-sm aspect-square z-10">
                <!-- Disco Deslizante -->
                <div class="absolute top-0 right-0 w-full h-full bg-[#111111] rounded-full shadow-2xl opacity-0 group-hover:opacity-100 group-hover:translate-x-[40%] group-hover:rotate-[30deg] transition-all duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] z-0 flex items-center justify-center border border-[#333]">
                    <div class="w-[85%] h-[85%] rounded-full border border-white/10 flex items-center justify-center">
                        <div class="w-[75%] h-[75%] rounded-full border border-white/5 flex items-center justify-center">
                            <div class="w-[30%] h-[30%] rounded-full bg-[#C49A5C] border-[6px] border-[#111111] flex items-center justify-center">
                                <div class="w-3 h-3 bg-[#111111] rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Funda -->
                @if($product->cover_url)
                    <img src="{{ $product->cover_url }}" alt="Portada de {{ $product->name }}" class="relative w-full h-full object-cover shadow-[0_20px_40px_rgba(0,0,0,0.2)] rounded-lg z-10 group-hover:-translate-x-4 transition-transform duration-1000 ease-[cubic-bezier(0.2,0.8,0.2,1)] bg-white">
                @else
                    <div class="relative w-full h-full bg-gray-100 shadow-[0_20px_40px_rgba(0,0,0,0.2)] rounded-lg z-10 flex items-center justify-center group-hover:-translate-x-4 transition-transform duration-1000 border border-gray-200">
                        <span class="text-[#C49A5C] font-black text-3xl uppercase tracking-widest text-center">Sin Portada</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Detalles -->
        <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center">
            <p class="text-[#C49A5C] text-sm font-bold tracking-[0.2em] uppercase mb-4">{{ $product->artist }}</p>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-[#111111] leading-tight mb-8">{{ $product->name }}</h1>
            
            <div class="flex items-end gap-4 mb-8 pb-8 border-b border-gray-100">
                @if($product->price > 0)
                    <p class="text-5xl font-black text-[#111111]">{{ number_format($product->price, 2, ',', '.') }} €</p>
                @else
                    <p class="text-2xl font-bold text-gray-400 uppercase tracking-widest">Agotado</p>
                @endif
            </div>
            
            <div class="space-y-6 mb-12 flex-grow">
                <p class="text-gray-600 text-lg leading-relaxed">{{ $product->description }}</p>
                
                <div class="flex flex-wrap gap-2 pt-4">
                    @foreach($product->genres as $genre)
                        <span class="bg-[#FBF9F6] text-[#111111] text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full">{{ $genre }}</span>
                    @endforeach
                    @foreach($product->styles as $style)
                        <span class="border border-[#C49A5C] text-[#C49A5C] text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full">{{ $style }}</span>
                    @endforeach
                    @if($product->year !== 'Desconocido' && $product->year !== '0')
                        <span class="bg-[#111111] text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full">Año: {{ $product->year }}</span>
                    @endif
                </div>
            </div>

            @if($product->price > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="artist" value="{{ $product->artist }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="cover_url" value="{{ $product->cover_url }}">
                    
                    <button type="submit" class="w-full bg-[#111111] hover:bg-[#C49A5C] text-white text-lg font-bold py-5 rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1 uppercase tracking-widest flex items-center justify-center gap-3">
                        Añadir al carrito
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(count($product->tracklist) > 0)
        <div class="max-w-4xl mx-auto mb-16">
            <h3 class="text-2xl font-black text-[#111111] uppercase tracking-widest mb-8 text-center">Tracklist</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2">
                @foreach($product->tracklist as $track)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 hover:border-[#C49A5C] transition-colors group">
                        <div class="flex gap-4 items-center">
                            <span class="text-[#C49A5C] font-bold w-6 text-right text-sm">{{ $track['position'] ?? '' }}</span>
                            <span class="text-[#111111] font-medium group-hover:text-[#C49A5C] transition-colors">{{ $track['title'] }}</span>
                        </div>
                        <span class="text-gray-400 text-sm font-bold">{{ $track['duration'] ?? '' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
