@extends('layout')

@section('title', 'Crear nuevo usuario')
    
@section('content')

    @component('shared._card')
        @slot('header')
            Crear nuevo usuario        
        @endslot
        @slot('content')
            <form method="POST" action="{{ url('usuarios') }}">
                @include('users._fields')
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>      
            </form>        
        @endslot
    @endcomponent
    
@endsection
