<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Http\Requests\UpdateProfessionRequest;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::query()
            ->withcount('profiles')
            ->orderBy('title')
            ->get();

        return view('professions.index', [
            'professions' => $professions,
        ]);
    }

    public function trashed()
    {                
        $professions = Profession::onlyTrashed()->get();
        
        $title = 'Papelera';

        return view('professions.trashed', compact('professions', 'title'));
    }

    public function show(Profession $profession)
    {
        if ($profession == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('professions.show', compact('profession'));
    }


    public function edit(Profession $profession)
    {
       //valores remplazados en le ViewServiceProvider View::composer

        return view('professions.edit', compact('profession'));
    }


    public function update(UpdateProfessionRequest $request, Profession $profession)
    {
        $request->updateProfession($profession);
        
        return redirect()->route('professions.show', ['profession' => $profession]);
    }

    public function trash(Profession $profession)
    {
        abort_if($profession->profiles()->exists(), 400, 'Cannot delete a profession linked a profile.');

        $profession->delete();

        return redirect()->route('professions.index');
    }

    public function destroy($id)
    {
        $profession = Profession::onlyTrashed()->where('id', $id)->firstOrFail();

        $profession->forceDelete();

        return redirect()->route('professions.trashed');
    }
}
