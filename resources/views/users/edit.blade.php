@extends('layout')

@section('title', 'Crear nuevo usuario')
    
@section('content')

    @component('shared._card')
        @slot('header')
            Editar usuario
        @endslot
        @slot('content')
            <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
                {{ method_field('PUT') }}
                @include('users._fields')
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-link">Regresar</a>
            </form>        
        @endslot
    @endcomponent
    
@endsection
