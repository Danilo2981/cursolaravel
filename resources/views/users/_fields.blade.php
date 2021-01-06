{{ csrf_field() }}
<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Pancho Pistolas" value="{{ old('name', $user->name) }}">
    <div id="nameHelp" class="form-text">
        @if ($errors->has('name'))
        <p>{{ $errors->first('name') }}</p>
        @endif
    </div>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="pancho@pistolas.com" value="{{ old('email', $user->email) }}">
    <div id="mailHelp" class="form-text">
        @if ($errors->has('email'))
            <p>{{ $errors->first('email') }}</p>
        @endif
</div>
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Mayor a 6 caracteres">
    <div id="pswHelp" class="form-text">
        @if ($errors->has('password'))
            <p>{{ $errors->first('password') }}</p>
        @endif
    </div>
</div>
<div class="mb-3">
    <label for="bio" class="form-label">Bio</label>
    <textarea name="bio" id="bio" cols="30" rows="3" class="form-control">{{ old('bio', $user->profile->bio) }}</textarea>
    <div id="bioHelp" class="form-text">
        @if ($errors->has('bio'))
            <p>{{ $errors->first('bio') }}</p>
        @endif
    </div>
</div>
<div class="mb-3">
    <label for="profession_id">Profesion</label>
    <select name="profession_id" id="profession_id" class="form-select" aria-label="Default select example">
        <option value="">Selecciona una profesión.</option>
    @foreach ($professions as $profession)
        <option value="{{ $profession->id }}"{{ old('profession_id', $user->profile->profession_id) == $profession->id ? ' selected' : '' }}>{{ $profession->title }}</option>              
    @endforeach
</select>
<div id="proHelp" class="form-text">
    @if ($errors->has('profession_id'))
        <p>{{ $errors->first('profession_id') }}</p>
    @endif
</div>
</div>
<div class="mb-3">
    <label for="twitter" class="form-label">Twitter</label>
    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="https://twitter.com/danilo" value="{{ old('twitter', $user->profile->twitter) }}">
    <div id="twitHelp" class="form-text">
        @if ($errors->has('twitter'))
            <p>{{ $errors->first('twitter') }}</p>
        @endif
</div>
</div>
<div class="mb-3">
    <h5>Habilidades</h5>
    @foreach ($skills as $skill)
        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
        <input name="skills[{{ $skill->id }}]" 
        type="checkbox" 
        class="btn-check" 
        id="skill_{{ $skill->id }}" 
        autocomplete="off" 
        value="{{ $skill->id }}"
        {{ $errors->any() ? old("skills.{$skill->id}") : (($user->skills->contains($skill)) ? 'checked' : '') }}>
        <label class="btn btn-outline-primary" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
        </div>
    @endforeach
</div>
<div class="mb-3">
    <h5>Roles</h5>
    @foreach ($roles as $role => $name)
    <div class="form-check form-switch">
        <input class="form-check-input" 
        type="radio"
        name="role" 
        id="role_{{ $role }}" 
        value="{{ $role }}"
        {{ old('role', $user->role) == $role ? 'checked' : '' }}>
        <label class="form-check-label" for="role_{{ $role }}">{{ $name }}</label>
    </div>         
    @endforeach
</div>