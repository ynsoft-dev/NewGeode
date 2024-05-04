<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sites')->delete();
        DB::table('sites')->insert([
                [   'id' => 1,
                    'name' => 'Cevital Salle 1',
                ],
                [   'id' => 2,
                    'name' => 'Cevital Salle 2',
                ],
                [   'id' => 3,
                    'name' => 'El Kseur Salle 1',
                ],
                [   'id' => 4,
                    'name' => 'LLK Salle 1',
                ],
                [   'id' => 5,
                    'name' => 'LLK Salle 2',
                ],
            ]
        );
    }
}
