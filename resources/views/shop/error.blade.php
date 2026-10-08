@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[50vh] py-12">
        <div class="max-w-xl w-full bg-white p-12 md:p-16 rounded-3xl shadow-xl border border-gray-100 text-center">
            
            <div class="w-20 h-20 mx-auto mb-8 bg-red-50 text-red-500 flex items-center justify-center rounded-full">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>

            <h2 class="text-3xl md:text-4xl font-black text-[#111111] mb-4 uppercase tracking-widest">Servidor Saturado</h2>
            
            <p class="text-gray-500 mb-10">
                La API de Discogs está experimentando un alto volumen de tráfico en este momento. Por favor, intenta buscar o cargar la página de nuevo en unos segundos.
            </p>

            <a href="{{ route('tienda') }}" class="inline-block bg-[#111111] hover:bg-[#C49A5C] text-white font-bold py-4 px-10 rounded-full transition-colors uppercase tracking-[0.2em] text-xs shadow-lg">
                Volver a la Tienda
            </a>
        </div>
    </div>
@endsection
