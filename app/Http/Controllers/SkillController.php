<?php

namespace App\Http\Controllers;

use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        return view('skills.index', [
            'skills' => Skill::orderBy('name')->get(),
        ]);
    }

    public function destroy(Skill $skill)
    {
        abort_if($skill->exists(), 400, 'Cannot delete a skill linked a profile.');

        $skill->delete();

        return redirect('habilidades');
    }
}
