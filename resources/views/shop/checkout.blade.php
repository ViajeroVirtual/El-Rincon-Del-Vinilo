@extends('layouts.app')

@section('content')
    <div class="mb-10 text-center">
        <h2 class="text-4xl md:text-5xl font-black text-[#111111] uppercase tracking-widest">Finalizar Compra</h2>
    </div>

    @if ($errors->any())
        <div class="mb-10 p-6 bg-red-50 text-red-600 font-medium text-sm rounded-xl border border-red-100">
            <p class="font-bold uppercase tracking-widest mb-4 text-xs">Por favor, revisa los siguientes errores:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Formulario -->
        <div class="flex-grow">
            <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form" class="space-y-8">
                @csrf
                
                <!-- Datos de envío -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-[#111111] mb-8 border-b border-gray-100 pb-4 uppercase tracking-widest">Datos de Envío</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Dirección de Entrega</label>
                            <input type="text" name="address" value="{{ old('address') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all">
                        </div>
                        <div>
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Ciudad</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all">
                        </div>
                        <div>
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Código Postal</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all">
                        </div>
                    </div>
                </div>

                <!-- Pago simulación -->
                <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-xl font-black text-[#111111] mb-8 border-b border-gray-100 pb-4 uppercase tracking-widest">Pago Seguro</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Número de Tarjeta</label>
                            <input type="text" name="cc_number" placeholder="0000 0000 0000 0000" value="{{ old('cc_number') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all tracking-widest font-mono">
                        </div>
                        <div>
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">Caducidad (MM/YY)</label>
                            <input type="text" name="cc_expiry" placeholder="12/26" value="{{ old('cc_expiry') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all text-center tracking-widest font-mono">
                        </div>
                        <div>
                            <label class="block text-gray-500 font-bold uppercase tracking-widest text-[10px] mb-2">CVC</label>
                            <input type="text" name="cc_cvc" placeholder="123" value="{{ old('cc_cvc') }}" required class="w-full bg-[#FBF9F6] border-none rounded-xl p-4 text-[#111111] focus:ring-2 focus:ring-[#C49A5C] transition-all text-center tracking-widest font-mono">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Resumen lateral -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 sticky top-24">
                <h3 class="text-xl font-black text-[#111111] mb-6 border-b border-gray-100 pb-4 uppercase tracking-widest">Resumen del Pedido</h3>
                
                <div class="space-y-4 mb-8">
                    @foreach($cart as $item)
                        <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                            <div class="truncate pr-4">
                                <p class="text-[10px] text-[#C49A5C] font-bold uppercase tracking-widest truncate mb-1">{{ $item['artist'] }}</p>
                                <p class="font-medium text-sm truncate text-[#111111]">{{ $item['name'] }} <span class="text-xs text-gray-400 ml-1">x{{ $item['quantity'] }}</span></p>
                            </div>
                            <span class="font-bold text-[#111111]">{{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }} €</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Subtotal</span>
                        <span class="font-bold text-[#111111]">{{ number_format($total, 2, ',', '.') }} €</span>
                    </div>
                    <div class="flex justify-between text-gray-600 text-sm">
                        <span>Envío</span>
                        <span class="text-[#C49A5C] font-bold uppercase tracking-widest text-xs self-center">Gratis</span>
                    </div>
                    <div class="flex justify-between text-2xl font-black text-[#111111] pt-6 border-t border-gray-100 mt-4">
                        <span>Total</span>
                        <span>{{ number_format($total, 2, ',', '.') }} €</span>
                    </div>
                </div>
                
                <button type="button" onclick="document.getElementById('checkout-form').submit();" class="w-full block text-center bg-[#111111] hover:bg-[#C49A5C] text-white text-sm font-bold py-5 rounded-xl transition-colors uppercase tracking-[0.2em] shadow-lg">
                    Confirmar Pedido
                </button>
            </div>
        </div>
    </div>
@endsection
