@extends('layouts.app')

@section('content')
    {{-- <h1>{{$receta}}</h1> --}}

    <article class="contenido-receta">
        <h1 class="text-center mb-4">{{$receta->titulo}}</h1>
        <div class="imagen-receta">
            <img src="{{asset('storage').'/'.$receta->imagen}}" alt="" class="w-100">
        </div>
        <div class="receta-meta">
            <p>
                <span class="font-weight-bold text-primary">Escrito en:</span>
                {{$receta->categoria->nombre}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">Autor</span>
                {{-- Mostrar el Usuario --}}
                {{$receta->autor->name}}
            </p>
            <p>
                <span class="font-weight-bold text-primary">Fecha</span>
                @php
                    $fecha = $receta->created_at
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
                
            </p>
            
            
            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredientes</h2>
                {!!$receta->ingredientes!!} {{-- De esta forma evitamos que se muestre el codigo html --}}
                
            </div>
            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparacion</h2>
                {!!$receta->preparacion!!} {{-- De esta forma evitamos que se muestre el codigo html --}}
                
            </div>
        </div>
    </article>
@endsection