@extends('layout')

@section('title', 'Habilidades')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="pb-1">Listado de habilidades</h1>
        <p>
            <a href=" {{ route('skills.index') }}" class="btn btn-primary">Habilidades</a>
        </p>
    </div>

    @if ($skills -> isNotEmpty())
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($skills as $skill)
            <tr>
                <th scope="row">{{ $skill->id }}</th>
                <td>{{ $skill->name }}</td>
                <td>
                    <form action="{{ url("habilidades/{$skill->id}") }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link"><i class="fas fa-skull"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p> No hay habilidades eliminadas.</p> 
    @endif

    
@endsection

@section('sidebar')
    @parent
@endsection