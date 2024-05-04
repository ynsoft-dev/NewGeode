<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ColumnsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('columns')->delete();
        DB::table('columns')->insert([
            [  'id' => 1,  'name' => 'C1', 'ray_id' => 1, 'site_id'=> 1 ],
            [  'id' => 2,  'name' => 'C2', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 3,  'name' => 'C3', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 4,  'name' => 'C4', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 5,  'name' => 'C5', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 6,  'name' => 'C6', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 7,  'name' => 'C7', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 8,  'name' => 'C8', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 9,  'name' => 'C9', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 10,  'name' => 'C10', 'ray_id' => 1, 'site_id'=> 1  ],
            [  'id' => 11,  'name' => 'C1', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 12,  'name' => 'C2', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 13,  'name' => 'C3', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 14,  'name' => 'C4', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 15,  'name' => 'C5', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 16,  'name' => 'C6', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 17,  'name' => 'C7', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 18,  'name' => 'C8', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 19,  'name' => 'C9', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 20,  'name' => 'C10', 'ray_id' => 2, 'site_id'=> 1  ],
            [  'id' => 21,  'name' => 'C1', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 22,  'name' => 'C2', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 23,  'name' => 'C3', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 24,  'name' => 'C4', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 25,  'name' => 'C5', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 26,  'name' => 'C6', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 27,  'name' => 'C7', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 28,  'name' => 'C8', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 29,  'name' => 'C9', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 30,  'name' => 'C10', 'ray_id' => 3, 'site_id'=> 2  ],
            [  'id' => 31,  'name' => 'C1', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 32,  'name' => 'C2', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 33,  'name' => 'C3', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 34,  'name' => 'C4', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 35,  'name' => 'C5', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 36,  'name' => 'C6', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 37,  'name' => 'C7', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 38,  'name' => 'C8', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 39,  'name' => 'C9', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 40,  'name' => 'C10', 'ray_id' => 4, 'site_id'=> 2   ],
            [  'id' => 41,  'name' => 'C1', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 42,  'name' => 'C2', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 43,  'name' => 'C3', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 44,  'name' => 'C4', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 45,  'name' => 'C5', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 46,  'name' => 'C6', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 47,  'name' => 'C7', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 48,  'name' => 'C8', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 49,  'name' => 'C9', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 50,  'name' => 'C10', 'ray_id' => 5, 'site_id'=> 3   ],
            [  'id' => 51,  'name' => 'C1', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 52,  'name' => 'C2', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 53,  'name' => 'C3', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 54,  'name' => 'C4', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 55,  'name' => 'C5', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 56,  'name' => 'C6', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 57,  'name' => 'C7', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 58,  'name' => 'C8', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 59,  'name' => 'C9', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 60,  'name' => 'C10', 'ray_id' => 6, 'site_id'=> 3   ],
            [  'id' => 61,  'name' => 'C1', 'ray_id' => 7, 'site_id'=> 4  ],
            [  'id' => 62,  'name' => 'C2', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 63,  'name' => 'C3', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 64,  'name' => 'C4', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 65,  'name' => 'C5', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 66,  'name' => 'C6', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 67,  'name' => 'C7', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 68,  'name' => 'C8', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 69,  'name' => 'C9', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 70,  'name' => 'C10', 'ray_id' => 7, 'site_id'=> 4   ],
            [  'id' => 71,  'name' => 'C1', 'ray_id' => 8, 'site_id'=> 5  ],
            [  'id' => 72,  'name' => 'C2', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 73,  'name' => 'C3', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 74,  'name' => 'C4', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 75,  'name' => 'C5', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 76,  'name' => 'C6', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 77,  'name' => 'C7', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 78,  'name' => 'C8', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 79,  'name' => 'C9', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 80,  'name' => 'C10', 'ray_id' => 8, 'site_id'=> 5   ],
            [  'id' => 81,  'name' => 'C1', 'ray_id' => 9, 'site_id'=> 1  ],
            [  'id' => 82,  'name' => 'C2', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 83,  'name' => 'C3', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 84,  'name' => 'C4', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 85,  'name' => 'C5', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 86,  'name' => 'C6', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 87,  'name' => 'C7', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 88,  'name' => 'C8', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 89,  'name' => 'C9', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 90,  'name' => 'C10', 'ray_id' => 9, 'site_id'=> 1   ],
            [  'id' => 91,  'name' => 'C1', 'ray_id' => 10, 'site_id'=> 2  ],
            [  'id' => 92,  'name' => 'C2', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 93,  'name' => 'C3', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 94,  'name' => 'C4', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 95,  'name' => 'C5', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 96,  'name' => 'C6', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 97,  'name' => 'C7', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 98,  'name' => 'C8', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 99,  'name' => 'C9', 'ray_id' => 10, 'site_id'=> 2   ],
            [  'id' => 100,  'name' => 'C10', 'ray_id' => 10, 'site_id'=> 2   ],

        ]
        );

        
        
    }
}