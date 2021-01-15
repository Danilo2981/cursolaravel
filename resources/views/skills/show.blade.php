@extends('layout')

@section('title', "Habilidad {$skill->id}")

@section('content')

  <div class="card" style="width: 36rem;">
     <div class="card-body">
       <h5 class="card-title">Habilidad {{$skill->name}}</h5>
       <h6 class="card-subtitle mb-2 text-muted">Detalle de la habilidad</h6>
       <p class="card-text">Nombre de la profesion: {{$skill->name}}</p>
       <a href="{{ route('skills.index') }}" class="btn btn-primary">Regresar</a>
     </div>
   </div>
  

@endsection