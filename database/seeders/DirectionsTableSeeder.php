<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('directions')->delete();

        DB::table('directions')->insert([
            [
                'id' => 1,
                'name' => 'DSI',
                'description' => 'Direction système d\'information',
            ],
            [
                'id' => 2,
                'name' => 'Transit',
                'description' => 'Direction Transit ',
            ],
            [
                'id' => 3,
                'name' => 'Commercial',
                'description' => 'Direction Commercial',
            ],
            [
                'id' => 4,
                'name' => 'RH',
                'description' => 'Direction RH',
            ],
            [
                'id' => 5,
                'name' => 'Finance et Comptabilite',
                'description' => 'Direction des Finances et Comptabilites',
            ],
        ]);
    }
}
