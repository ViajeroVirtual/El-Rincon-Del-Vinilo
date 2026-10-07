@extends('layouts.app')

@section('content')
    <h2>Lista de Vinilos Disponibles</h2>
    
    <div class="product-list">
        <!-- Punto de investigación: Lista generada con blade usando partial -->
        @foreach($products as $product)
            @include('partials._product', ['product' => $product])
        @endforeach
    </div>
@endsection
