<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Professor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  User::factory(10)->create();
         Professor::factory(1)->create();
         Admin::factory(1)->create();
    }
}
