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
    {{-- users es un objeto paginador por que en el modelo se esta usando paginate --}}
    <p>Pagina {{ $users->currentPage() }} de {{ $users->lastPage() }}</p>
    <table class="table table-sm">
        <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col" class="sort-desc">Nombre</th>
            <th scope="col">Empresa</th>
            <th scope="col">Correo</th>
            <th scope="col">Rol</th>
            <th scope="col">Fechas</th>
            <th scope="col" class="text-right th-actions">Acciones</th>
        </tr>
        </thead>
        <tbody>
            {{-- Remplaza al foreach y permite traer lo de la hoja _row     --}}
            @each('users._row', $users, 'user')
        </tbody>
    </table>

    {{-- appends ata la busqueda al request de la busqueda para que esta se mantenga al cambiar de pagina cuando esta filtrado     --}}
    {{-- fragment permite poner un hash a la url http://cursolaravel.test/usuarios?search=Dr.&page=2#table --}}
    {{ $users->appends(request(['search']))->fragment('table')->links() }}
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