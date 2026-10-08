<div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 flex flex-col h-full border border-gray-100 overflow-visible">
    
    <!-- Efecto Disco Deslizante -->
    <div class="absolute top-4 right-4 w-[90%] aspect-square bg-[#111111] rounded-full shadow-2xl opacity-0 group-hover:opacity-100 group-hover:translate-x-8 group-hover:rotate-[25deg] transition-all duration-700 ease-[cubic-bezier(0.2,0.8,0.2,1)] z-0 flex items-center justify-center border border-[#333]">
        <div class="w-[85%] h-[85%] rounded-full border border-white/10 flex items-center justify-center">
            <div class="w-[75%] h-[75%] rounded-full border border-white/5 flex items-center justify-center">
                <div class="w-[30%] h-[30%] rounded-full bg-[#C49A5C] border-4 border-[#111111] flex items-center justify-center">
                    <div class="w-2 h-2 bg-[#111111] rounded-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sleeve / Cover -->
    <a href="{{ route('shop.show', data_get($product, 'id')) }}" class="relative w-full aspect-square bg-gray-100 rounded-t-2xl overflow-hidden z-10 shadow-[0_10px_20px_rgba(0,0,0,0.1)]">
        @if(data_get($product, 'cover_url'))
            <img src="{{ data_get($product, 'cover_url') }}" alt="Portada de {{ data_get($product, 'name') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
        @else
            <div class="w-full h-full flex items-center justify-center bg-[#FBF9F6] text-[#C49A5C] font-bold tracking-widest uppercase text-sm">Sin Portada</div>
        @endif
        <!-- Gradiente superpuesto sutil -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    </a>
    
    <div class="p-5 flex flex-col flex-grow relative z-10 bg-white rounded-b-2xl">
        <p class="text-[#C49A5C] text-[10px] font-bold tracking-[0.2em] uppercase mb-1 line-clamp-1">{{ data_get($product, 'artist', 'Artista Desconocido') }}</p>
        <a href="{{ route('shop.show', data_get($product, 'id')) }}" class="inline-block mb-2">
            <h3 class="text-lg font-bold text-[#111111] leading-tight group-hover:text-[#C49A5C] transition-colors line-clamp-2">{{ data_get($product, 'name') }}</h3>
        </a>
        
        <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-100">
            @if(data_get($product, 'price', 0) > 0)
                <span class="text-[#111111] font-black text-lg">{{ number_format(data_get($product, 'price'), 2, ',', '.') }} €</span>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ data_get($product, 'id') }}">
                    <input type="hidden" name="name" value="{{ data_get($product, 'name') }}">
                    <input type="hidden" name="artist" value="{{ data_get($product, 'artist') }}">
                    <input type="hidden" name="price" value="{{ data_get($product, 'price') }}">
                    <input type="hidden" name="cover_url" value="{{ data_get($product, 'cover_url') }}">
                    
                    <button type="submit" class="bg-[#111111] hover:bg-[#C49A5C] text-white p-2 rounded-full transition-colors" title="Añadir al carrito">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </button>
                </form>
            @else
                <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">No disponible</span>
            @endif
        </div>
    </div>
</div>
