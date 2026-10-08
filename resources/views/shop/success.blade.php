@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[60vh] py-12">
        <div class="max-w-xl w-full bg-white p-12 md:p-16 rounded-3xl shadow-xl border border-gray-100 text-center">
            
            <div class="w-20 h-20 mx-auto mb-8 bg-[#C49A5C]/10 text-[#C49A5C] flex items-center justify-center rounded-full">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h2 class="text-3xl md:text-4xl font-black text-[#111111] mb-4 uppercase tracking-widest">¡Gracias por tu pedido!</h2>
            
            <p class="text-gray-500 mb-10">
                Tu compra ha sido procesada con éxito y estamos preparando tus vinilos.
            </p>
            
            <div class="bg-[#FBF9F6] p-8 rounded-2xl border border-gray-100 text-left mb-10">
                <p class="text-sm text-gray-500 mb-2">Número de Pedido:</p>
                <p class="text-2xl font-black text-[#111111] mb-8 tracking-widest">{{ $order->order_number }}</p>

                <p class="font-bold text-[#C49A5C] uppercase tracking-widest text-[10px] mb-4">Dirección de Envío</p>
                <div class="text-gray-700 font-medium text-sm space-y-1">
                    <p class="font-bold text-[#111111]">{{ $order->name }}</p>
                    <p>{{ $order->address }}</p>
                    <p>{{ $order->postal_code }} - {{ $order->city }}</p>
                    <p class="text-gray-400 mt-2">{{ $order->email }}</p>
                </div>
            </div>

            <a href="{{ route('tienda') }}" class="inline-block bg-[#111111] hover:bg-[#C49A5C] text-white font-bold py-4 px-10 rounded-full transition-colors uppercase tracking-[0.2em] text-xs shadow-lg">
                Volver a la Tienda
            </a>
        </div>
    </div>
@endsection
