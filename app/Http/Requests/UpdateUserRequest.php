<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
            'password' => '',
            'role' => Rule::in(Role::getlist()),
            'bio' => 'required',
            'twitter' => ['nullable', 'url'],
            'profession_id' => [
                'nullable', 
                Rule::exists('professions', 'id')->whereNull('deleted_at')],
            'skills' => [
                'array',
                Rule::exists('skills', 'id')]
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'El campo es obligatorio',
            'email.required' => 'El campo mail es obligatorio',
            'email.email' => 'El campo mail es de tipo mail',
            'email.unique' => 'El campo mail debe ser unico' 
        ];
    }

    public function updateUser(User $user)
    {
        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password != null) {
            $user->password = bcrypt($this->password);
        }
        
        $user->role = $this->role;
        $user->save();

        $user->profile->update([
            'twitter' => $this->twitter,
            'bio' => $this->bio,
            'profession_id' => $this->profession_id,
        ]);

        $user->skills()->sync($this->skills ?: []);
    }
}
