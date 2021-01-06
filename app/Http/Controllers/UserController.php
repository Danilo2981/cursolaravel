<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateUserRequest;
use App\Models\Skill;

class UserController extends Controller
{
    
    public function index()
    {                
        $users = User::all();
        
        $title = 'Listado de usuarios';

        return view('users.index', compact('users', 'title'));
    }

    public function show(User $user)
    {
        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    public function create()
    {
        $professions = Profession::orderBy('title', 'ASC')->get();
        $skills = Skill::orderBy('name', 'ASC')->get();
        $roles = trans('users.roles');

        return view('users.create', compact('professions', 'skills', 'roles'));
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();
       
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ''
        ],[
            'name.required' => 'El campo es obligatorio',
            'email.required' => 'El campo mail es obligatorio',
            'email.email' => 'El campo mail es de tipo mail',
            'email.unique' => 'El campo mail debe ser unico'            
        ]);
        
        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);    
        } else {
            unset($data['password']);
        }
        
        $user->update($data);
        
        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

}
