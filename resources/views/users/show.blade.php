 @extends('layout')

 @section('title', "Usuario {$user->id}")

 @section('content')

   <div class="card" style="width: 36rem;">
      <div class="card-body">
        <h5 class="card-title">Usuario {{$user->name}}</h5>
        <h6 class="card-subtitle mb-2 text-muted">Detalle del usuario</h6>
        <p class="card-text">Nombre del usuario: {{$user->name}}</p>
        <p class="card-text">Correo del usuario: {{$user->email}}</p>
        <a href="{{ route('users.index') }}" class="btn btn-primary">Regresar</a>
      </div>
    </div>
   
 
 @endsection

