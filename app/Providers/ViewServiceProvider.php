<?php

namespace App\Providers;

use App\Models\Skill;
use App\Models\Profession;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['users.create', 'users.edit', 'professions.edit'], function($view){
            $professions = Profession::orderBy('title', 'ASC')->get();
            $skills = Skill::orderBy('name', 'ASC')->get();
            $roles = trans('users.roles');
    
            $view->with(compact('professions', 'skills', 'roles'));
        });
    }
}
