@extends('layout')

@section('title', 'Habilidades')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Listado de habilidades</h1>
        <p>
            <a href=" {{ route('skills.trashed') }}" class="btn btn-primary">Papelera</a>
        </p>
    </div>

    @if ($skills -> isNotEmpty())
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
        @foreach($skills as $skill)
            <tr>
                <th scope="row">{{ $skill->id }}</th>
                <td>{{ $skill->name }}</td>
                <td>{{ $skill->skills_count }}</td>
                <td>
                    @if ($skill->skills_count == 0)
                    <form action="{{ route('skills.trash', $skill) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <a href="{{ route('skills.show', $skill) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-link"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-link"><i class="fas fa-trash"></i></button>
                    </form>
                    @elseif($skill->skills_count > 0)
                        <a href="{{ route('skills.show', $skill) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-link"><i class="fas fa-pen"></i></a>
                        <button type="submit" class="btn btn-link disabled"><i class="fas fa-trash"></i></button>
                    @endif 
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p> No hay habilidades registradas.</p> 
    @endif

    
@endsection

@section('sidebar')
    @parent
@endsection