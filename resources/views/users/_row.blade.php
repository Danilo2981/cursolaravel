<tr>
    <td rowspan="2">{{ $user->id }}</td>
    <th scope="row">
        {{ $user->name }}
        <span class="note">Nombre de Empresa</span>
    </th>
    <td>{{ $user->email }}</td>
    <td>{{ $user->role }}</td>
    <td>
        <span class="note">Registro: {{ $user->created_at->format('d/m/Y') }}</span>
        <span class="note">Último login: {{ $user->created_at->format('d/m/Y') }}</span>
    </td>
    <td class="text-right">
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
        <span class="note">Profesion aqui</span>
    </td>
    <td colspan="4"><span class="note">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos, libero veniam minus voluptatem adipisci error. Quo fugiat rem placeat dolores quaerat repudiandae quibusdam veniam porro ad consectetur, quas ab. Facere.</span></td>
</tr>