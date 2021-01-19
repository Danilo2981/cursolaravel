@extends('layout')

@section('title', 'Profesiones')

@section('content')

@component('shared._card')
        @slot('header')
            Editar profesion
        @endslot
        @slot('content')
            <form method="POST" action="{{ url("profesiones/{$profession->id}") }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="title">Profesion</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Ingrese su profesión" value="{{ old('title', $profession->title) }}">
                    <div id="titleHelp" class="form-text">
                        @if ($errors->has('title'))
                        <p>{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Profesion</button>
                <a href="{{ route('professions.index') }}" class="btn btn-link">Regresar</a>
            </form>        
        @endslot
    @endcomponent
    
@endsection

@section('sidebar')
    @parent
@endsection