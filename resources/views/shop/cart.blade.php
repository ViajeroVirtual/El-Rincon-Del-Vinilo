@extends('layouts.app')

@section('content')
    <div class="mb-10 text-center">
        <h2 class="text-4xl md:text-5xl font-black text-[#111111] uppercase tracking-widest">Cesta de la Compra</h2>
    </div>

    @if(session('success'))
        <div class="mb-8 p-4 bg-[#C49A5C]/10 text-[#C49A5C] font-bold uppercase tracking-wider text-sm rounded-xl border border-[#C49A5C]/30 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="flex flex-col lg:flex-row gap-10">
            <!-- Detalles de productos -->
            <div class="flex-grow space-y-6">
                @foreach($cart as $id => $details)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6 relative group">
                        <div class="w-20 h-20 md:w-28 md:h-28 bg-[#FBF9F6] rounded-lg overflow-hidden flex-shrink-0 shadow-inner">
                            @if($details['cover_url'])
                                <img src="{{ $details['cover_url'] }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[#C49A5C]/50 text-[10px] font-bold uppercase flex items-center justify-center h-full text-center">Sin Portada</span>
                            @endif
                        </div>
                        
                        <div class="flex-grow">
                            <p class="text-[#C49A5C] text-[10px] md:text-xs font-bold tracking-[0.2em] uppercase mb-1">{{ $details['artist'] }}</p>
                            <h3 class="text-lg md:text-xl font-bold text-[#111111] leading-tight mb-2">{{ $details['name'] }}</h3>
                            <p class="text-gray-500 text-sm font-medium">Cantidad: <span class="font-bold text-[#111111]">{{ $details['quantity'] }}</span></p>
                        </div>
                        
                        <div class="text-right pr-10">
                            <p class="text-[#111111] font-black text-xl md:text-2xl">{{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }} €</p>
                        </div>
                        
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="absolute top-1/2 -translate-y-1/2 right-4">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors" title="Eliminar del carrito">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            
            <!-- Resumen y Checkout -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 sticky top-24">
                    <h3 class="text-xl font-black text-[#111111] mb-6 border-b border-gray-100 pb-4 uppercase tracking-widest">Resumen</h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-gray-600 font-medium">
                            <span>Subtotal</span>
                            <span>{{ number_format($total, 2, ',', '.') }} €</span>
                        </div>
                        <div class="flex justify-between text-gray-600 font-medium">
                            <span>Envío</span>
                            <span class="text-[#C49A5C] font-bold uppercase tracking-widest text-sm">Gratis</span>
                        </div>
                        <div class="flex justify-between text-2xl font-black text-[#111111] pt-6 border-t border-gray-100 mt-6">
                            <span>Total</span>
                            <span>{{ number_format($total, 2, ',', '.') }} €</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="w-full block text-center bg-[#111111] hover:bg-[#C49A5C] text-white text-sm font-bold py-5 rounded-xl transition-colors uppercase tracking-[0.2em] shadow-lg">
                        Continuar Pedido
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="w-20 h-20 bg-[#FBF9F6] rounded-full flex items-center justify-center mx-auto mb-6 text-[#C49A5C]">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-[#111111] mb-4 uppercase tracking-widest">Tu cesta está vacía</h3>
            <p class="text-gray-500 mb-8">Aún no has seleccionado ningún vinilo.</p>
            <a href="{{ route('tienda') }}" class="inline-block bg-[#111111] hover:bg-[#C49A5C] text-white font-bold py-4 px-10 rounded-full transition-colors uppercase tracking-[0.2em] text-xs shadow-lg">Descubrir Novedades</a>
        </div>
    @endif
@endsection
