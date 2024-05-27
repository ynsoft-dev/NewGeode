<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        $permissions = [

            'users',

            'users_lists',
            'add_user',
            'edit_user',
            'delete_user',

            'admin',
            
            'users_permissions',
            'add_permission',
            'edit_permission',
            'delete_permission',
            'show_permission',

            'structure',

            'directions',
            'add_direction',
            'edit_direction',
            'delete_direction',

            'departments',
            'add_department',
            'edit_department',
            'delete_department',

            'locations',

            'sites',
            'add_site',
            'edit_site',
            'delete_site',

            'rays',
            'add_ray',
            'edit_ray',
            'delete_ray',

            'columns',
            'add_column',
            'edit_column',
            'delete_column',

            'shelves',
            'add_shelf',
            'edit_shelf',
            'delete_shelf',

            'structureApplicant',
            'archiveRequest',
            'loanRequest',

            'structureArchiviste',
            'archive_boxes',
            'loans',

            'notifications',
            'process_loan',




        ];

        foreach ($permissions as $permission) {

            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
}
