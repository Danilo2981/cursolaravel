@extends('layout')

@section('title', 'Crear nuevo usuario')
    
@section('content')

   <h1>Editar usuario</h1>
  
    <form method="POST" action="{{ url("usuarios/{$user->id}") }}">
      {{ method_field('PUT') }}
      {{ csrf_field() }}
      <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Pancho Pistolas" value="{{ old('name', $user->name) }}">
        <div id="nameHelp" class="form-text">
          @if ($errors->has('name'))
              <p>{{ $errors->first('name') }}</p>
          @endif
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="pancho@pistolas.com" value="{{ old('email', $user->email) }}">
        <div id="mailHelp" class="form-text">
          @if ($errors->has('email'))
              <p>{{ $errors->first('email') }}</p>
          @endif
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Mayor a 6 caracteres">
        <div id="mailHelp" class="form-text">
          @if ($errors->has('password'))
              <p>{{ $errors->first('password') }}</p>
          @endif
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
      <a href="{{ route('users.index') }}" class="btn btn-link">Regresar</a>
    </form>
   
@endsection
