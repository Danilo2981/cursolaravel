@extends('layout')

@section('title', "Profesion {$profession->id}")

@section('content')

  <div class="card" style="width: 36rem;">
     <div class="card-body">
       <h5 class="card-title">Profesion {{$profession->title}}</h5>
       <h6 class="card-subtitle mb-2 text-muted">Detalle de la profesion</h6>
       <p class="card-text">Nombre de la profesion: {{$profession->title}}</p>
       <a href="{{ route('professions.index') }}" class="btn btn-primary">Regresar</a>
     </div>
   </div>
  

@endsection