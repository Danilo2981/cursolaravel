@extends('layout') 

@section('content')

<div class="d-flex justify-content-between align-items-end mb-2">
    <h1 class="pb-1">{{ $title }}</h1>
    <p>
        <a href=" {{ route('users.index') }}" class="btn btn-primary">Usuarios</a>
    </p>
</div>

@if($users -> isNotEmpty()) 

<table class="table table-striped table-hover">
<thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Correo</th>
        <th scope="col">Acciones</th>
    </tr>
</thead>
<tbody>
    @foreach ($users as $user)
    <tr>
        <th scope="row">{{ $user->id }}</th>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <form action="{{ route('users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link"><i class="fas fa-skull"></i></button>
                <a class="btn btn-link" title="Undo delete" href="{{route('users.restore',$user->id)}}"><i class="fas fa-recycle"></i></a>
            </form>                        
        </td>
    </tr>
    @endforeach
</tbody>
</table>
@else 
<p> No hay usuarios eliminados.</p>
@endif

@endsection 

@section('sydebar')

<h2>Barra Lateral Customize</h2>

@endsection