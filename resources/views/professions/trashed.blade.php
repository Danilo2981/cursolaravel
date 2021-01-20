@extends('layout')

@section('title', 'Profesiones')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Listado de profesiones</h1>
        <p>
            <a href=" {{ route('professions.index') }}" class="btn btn-primary">Profesiones</a>
        </p>
    </div>

    @if ($professions -> isNotEmpty())
        
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($professions as $profession)
            <tr>
                <th scope="row">{{ $profession->id }}</th>
                <td>{{ $profession->title }}</td>
                <td>
                    <form action="{{ url("profesiones/{$profession->id}") }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link"><i class="fas fa-skull"></i></button>
                        <a class="btn btn-link" title="Undo delete" href="{{route('professions.restore',$profession->id)}}"><i class="fas fa-recycle"></i></a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @else
      <p> No hay profesiones eliminadas.</p>
    @endif

    
@endsection

@section('sidebar')
    @parent
@endsection