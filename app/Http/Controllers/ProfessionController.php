<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Http\Requests\UdateProfessionRequest;

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

    public function show(Profession $profession)
    {
        return view('professions.show', compact('profession'));
    }


    public function edit(Profession $profession)
    {
       //valores remplazados en le ViewServiceProvider View::composer

        return view('professions.edit', compact('profession'));
    }


    public function update(UdateProfessionRequest $request, Profession $profession)
    {
        $request->updateProfession($profession);
        
        return redirect()->route('professions.show', ['profession' => $profession]);
    }

    public function destroy(Profession $profession)
    {
        abort_if($profession->profiles()->exists(), 400, 'Cannot delete a profession linked a profile.');

        $profession->delete();

        return redirect('profesiones');
    }
}
