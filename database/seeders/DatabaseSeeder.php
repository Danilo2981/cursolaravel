<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'professions',
            'skills',
            'users',
            'user_profiles',
            'user_skill',
            'teams'
        ]);

        $this->call([
            ProfessionSeeder::class,
            SkillSeader::class,
            TeamSeeder::class,
            UserSeeder::class
        ]);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach ($tables as $table) {
            DB::table($table)->truncate();        
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
    }
}
