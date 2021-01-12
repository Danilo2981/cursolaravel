<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'role' => ['nullable', Rule::in(Role::getlist())],
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
            'email.unique' => 'El campo mail debe ser unico',
            'password.required' => 'El campo password es obligatorio',
            'password.min' => 'El campo password debe tener mas de 6 caracteres',
            'role' => '',
            'bio' => 'El campo bio es obligatorio',
            'twitter' => 'El campo twitter es de tipo URL',
            'profession_id' => 'La profesion debe ser valida',
            'skills' => ''
        ];
    }


    public function createUser()
    {
        DB::transaction(function(){

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt($this->password),
                'role' => $this->role  ?? 'user',
            ]);
    
            $user->profile()->create([
                'bio' => $this->bio,
                'twitter' => $this->twitter,
                'profession_id' => $this->profession_id
            ]);
            
            if ($this->skills != null) {
                $user->skills()->attach($this->skills);
            }
            
        });           
    }
}
