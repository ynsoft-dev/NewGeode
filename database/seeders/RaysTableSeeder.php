<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rays')->delete();

        DB::table('rays')->insert([
            [   'id' => 1,
                'name' => 'R1',
                'site_id' => 1,
            ],
            [   'id' => 2,
                'name' => 'R2',
                'site_id' => 1,
            ],
            [   'id' => 3,
                'name' => 'R3',
                'site_id' => 1,
            ],
            [   'id' => 4,
                'name' => 'R1',
                'site_id' => 2,
            ],
            [   'id' => 5,
                'name' => 'R2',
                'site_id' => 2,
            ],
            [   'id' => 6,
                'name' => 'R3',
                'site_id' => 2,
            ],
            [   'id' => 7,
                'name' => 'R1',
                'site_id' => 3,
            ],
            [   'id' => 8,
                'name' => 'R2',
                'site_id' => 3,
            ],
            [   'id' => 9,
                'name' => 'R3',
                'site_id' => 3,
            ],
            [   'id' => 10,
                'name' => 'R1',
                'site_id' => 4,
            ],
            [   'id' => 11,
                'name' => 'R2',
                'site_id' => 4,
            ],
            [   'id' => 12,
                'name' => 'R3',
                'site_id' => 4,
            ],
            [   'id' => 13,
                'name' => 'R1',
                'site_id' => 5,
            ],
            [   'id' => 14,
                'name' => 'R2',
                'site_id' => 5,
            ],
            [   'id' => 15,
                'name' => 'R3',
                'site_id' => 5,
            ],
        ]
        );

    }
}
