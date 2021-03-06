<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    
    public function index()
    {                
        // simplePaginate para ver solo anterior y siguiente
        $users = User::query()
                // profile.profeesion permite traer el campo profesion a la relacion usuario - profile
                ->with('team', 'profile', 'skills', 'profile.profession')        //establece la relacion con la que va a ejecutar las busquedas
                // Consulta con radios
                ->when(request('team'), function($query, $team){
                    if ($team === 'with_team') {  //relacionado con el value de la vista
                        $query->has('team');
                    } elseif ($team === 'without_team') {
                        $query->doesntHave('team');
                    }
                    
                })                    
                ->search(request('search'))
                ->orderBy('created_at', 'DESC')
                ->paginate();
        
        $title = 'Listado de usuarios';

        return view('users.index', compact('users', 'title'));
    }

    public function trashed()
    {                
        $users = User::onlyTrashed()->get();
        
        $title = 'Papelera';

        return view('users.trashed', compact('users', 'title'));
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

    public function trash(User $user)
    {
        $user->delete();
                
        return redirect()->route('users.index');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();
        $user->profile()->restore();

        DB::table('user_skill')
            ->where('user_id', $user->id)
            ->update(array('deleted_at' => null));
        
        $user->restore();

        return redirect()->route('users.trashed');
    }

    public function destroy($id)
    {
        $user = User::onlyTrashed()->where('id', $id)->firstOrFail();

        $user->forceDelete();

        return redirect()->route('users.trashed');
    }

}
