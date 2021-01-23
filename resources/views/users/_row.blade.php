<tr>
    <td rowspan="2" class="text-center">{{ $user->id }}</td>
        <th>
            <blockquote class="blockquote">
                <h6>{{ $user->name }}</h6>
            </blockquote>            
            <figcaption class="blockquote-footer fw-lighter">
                <cite>Nombre</cite>
            </figcaption>
        </th>
    <td class="fw-lighter">{{ $user->team->name }}</td>
    <td class="fw-lighter">{{ $user->email }}</td>
    <td class="fw-lighter">{{ $user->role }}</td>
    <td>
        <p class="fw-lighter mb-0">Registro: {{ $user->created_at->format('d/m/Y') }}</p>
        <p class="fw-lighter">Último login: {{ $user->created_at->format('d/m/Y') }}</p>
    </td>
    <td class="">
        @if ($user->trashed())
            <form action="{{ route('users.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link"><span class="oi oi-circle-x"></span></button>
            </form>
        @else
            <form action="{{ route('users.trash', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <a href="{{ route('users.show', $user) }}" class="btn btn-link"><i class="fas fa-eye"></i></a>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-link"><i class="fas fa-pen"></i></a>
                <button type="submit" class="btn btn-link"><i class="fas fa-trash"></i></button>
            </form>
        @endif
    </td>
</tr>
<tr class="skills">
    <td colspan="1">
        {{-- trae el valor del modelo User funcion profile y del Modelo Profession funcion profession
            se puede usar tabien el metodo option($user->profile->profession->title) --}}
        @if ($user->profile->profession)
        <h6 class="fw-lighter">{{ $user->profile->profession->title }}</h6>    
        @endif        
    </td>
    <td colspan="4">
        <p class="fw-lighter mb-0">{{ $user->skills->implode('name', ', ') ?: 'Sin habilidades :(' }}</p>
    </td>
</tr>