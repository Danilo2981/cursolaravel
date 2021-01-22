@extends('layout') 

@section('title', 'Usuarios')

@section('content')

<div class="d-flex justify-content-between align-items-end">
    <h1 class="pb-1">{{ $title }}</h1>
    <p>
        <a href="{{ route('users.create') }}" class="btn btn-outline-success">Nuevo Usuario</a>
        <a href=" {{ route('users.trashed') }}" class="btn btn-outline-success">Papelera</a>
    </p>
</div>

@include('users._filters')

@if($users -> isNotEmpty()) 

<div class="table-responsive-lg mt-2">
    <table class="table table-sm">
        <thead class="table-dark">
        <tr>
            <th scope="col"># <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
            <th scope="col" class="sort-desc">Nombre <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
            <th scope="col">Correo <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
            <th scope="col">Rol <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
            <th scope="col">Fechas <span class="oi oi-caret-bottom"></span><span class="oi oi-caret-top"></span></th>
            <th scope="col" class="text-right th-actions">Acciones</th>
        </tr>
        </thead>
        <tbody>
            {{-- Remplaza al foreach y permite traer lo de la hoja _row     --}}
            @each('users._row', $users, 'user')
        </tbody>
    </table>

    {{ $users->render() }}
</div>

{{-- Pone la paginacion al pie --}}
{{-- {{ $users->render() }} se puede usar tambien ->links() --}}

{{-- para corregir html estilos usar php artisan vendor:publish --}}
{{-- para configurar en todas las paginas hacerlo en AppServiceProvider --}}

@else 
<p> No hay usuarios registrados.</p>
@endif

@endsection 

{{-- @section('sydebar')

<h2>Barra Lateral Customize</h2>

@endsection --}}