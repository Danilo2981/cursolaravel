@extends('layout')

@section('title', 'Habilidades')

@section('content')

@component('shared._card')
        @slot('header')
            Editar habilidad
        @endslot
        @slot('content')
            <form method="POST" action="{{ url("habilidades/{$skill->id}") }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="name">Habilidad</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su habilidad" value="{{ old('name', $skill->name) }}">
                    <div id="nameHelp" class="form-text">
                        @if ($errors->has('name'))
                        <p>{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Habilidad</button>
                <a href="{{ route('skills.index') }}" class="btn btn-link">Regresar</a>
            </form>        
        @endslot
    @endcomponent
    
@endsection