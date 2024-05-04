<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('departments')->delete();
        
        DB::table('departments')->insert( [
            [   'id' => 1,
                'name' => 'IMPORT',
                'directions_id' => 2,
            ],
            [   'id' => 2,
                'name' => 'Sce Clients',
                'directions_id' => 3,
            ],
            [   'id' => 3,
                'name' => 'Sce Distribution Direct',
                'directions_id' => 3,
            ],
            [   'id' => 4,
                'name' => 'Sce Facturation',
                'directions_id' => 3,
            ],
            [   'id' => 5,
                'name' => 'MGX',
                'directions_id' => 4,
            ],
            [   'id' => 6,
                'name' => 'MGX Transport',
                'directions_id' => 4,
            ],
            [   'id' => 7,
                'name' => 'Paie',
                'directions_id' => 4,
            ],
            [   'id' => 8,
                'name' => 'RECRUTEMENT',
                'directions_id' => 4,
            ],
            [   'id' => 9,
                'name' => 'Ressource Humaines',
                'directions_id' => 5,
            ],
            [   'id' => 10,
                'name' => 'IMMO PROJET',
                'directions_id' => 5,
            ],
            [   'id' => 11,
                'name' => 'IMMO PROJET ETRANGER',
                'directions_id' => 5,
            ],
            [   'id' => 12,
                'name' => 'Juridique et Assurance',
                'directions_id' => 5,
            ],
            [   'id' => 13,
                'name' => 'Moyens Généraux',
                'directions_id' => 5,
            ],
           
        
        ]);
        
        
    }
}