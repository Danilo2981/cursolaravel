<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

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
        //valores remplazados en le ViewServiceProvider View::composer

        //Crear un usuario por defecto para utilizar misma plantilla _fields
        $user = new User;

        return view('users.create', compact('user'));
    }

    public function store(CreateUserRequest $request)
    {
        $request->createUser();
       
        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
       //valores remplazados en le ViewServiceProvider View::composer

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request->updateUser($user);
        
        return redirect()->route('users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

}
