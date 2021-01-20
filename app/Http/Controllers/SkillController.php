<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Http\Requests\UpdateSkillRequest;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::query()
            ->withCount('skills')
            ->orderBy('name')
            ->get();
      
        return view('skills.index', [
            'skills' => $skills,
        ]);
    }

    public function trashed()
    {                
        $skills = Skill::onlyTrashed()->get();
        
        $title = 'Papelera';

        return view('skills.trashed', compact('skills', 'title'));
    }

    public function show(Skill $skill)
    {
        if ($skill == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('skills.show', compact('skill'));
    }


    public function edit(Skill $skill)
    {
       //valores remplazados en le ViewServiceProvider View::composer

        return view('skills.edit', compact('skill'));
    }


    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $request->updateSkill($skill);
        
        return redirect()->route('skills.show', ['skill' => $skill]);
    }

    public function trash(Skill $skill)
    {
        abort_if($skill->skills()->exists(), 400, 'Cannot delete a skill linked a user.');

        $skill->delete();

        return redirect()->route('skills.index');
    }

    public function restore($id)
    {
        $skill = Skill::onlyTrashed()->where('id', $id)->firstOrFail();
        $skill->restore();

        return redirect()->route('skills.index');
    }

    public function destroy($id)
    {
        $skill = Skill::onlyTrashed()->where('id', $id)->firstOrFail();

        $skill->forceDelete();

        return redirect()->route('skills.trashed');
    }

}
