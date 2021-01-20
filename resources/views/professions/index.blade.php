@extends('layout')

@section('title', 'Profesiones')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Listado de profesiones</h1>
        <p>
            <a href=" {{ route('professions.trashed') }}" class="btn btn-primary">Papelera</a>
        </p>
    </div>

    @if ($professions -> isNotEmpty())
        
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Perfiles</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($professions as $profession)
            <tr>
                <th scope="row">{{ $profession->id }}</th>
                <td>{{ $profession->title }}</td>
                <td>{{ $profession->profiles_count }}</td>
                <td>
                    @if ($profession->profiles_count == 0)
                    <form action="{{ route('professions.trash', $profession) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <a href="{{ route('professions.show', $profession) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('professions.edit', $profession) }}" class="btn btn-link"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-link"><i class="fas fa-trash"></i></button>
                    </form>
                    @elseif($profession->profiles_count > 0)
                        <a href="{{ route('professions.show', $profession) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('professions.edit', $profession) }}" class="btn btn-link"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-link disabled"><i class="fas fa-trash"></i></button>
                    @endif 
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @else
      <p> No hay profesiones registradas.</p>
    @endif

    
@endsection

@section('sidebar')
    @parent
@endsection