<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users',
            'add_user',
            'edit_user',
            'delete_user',

            'users_lists',

            'users_permissions',
            'add_permission',
            'edit_permission',
            'delete_permission',

            
            'directions',
            'add_direction',
            'edit_direction',
            'delete_direction',

            'departements',
            'add_departement',
            'edite_departement',
            'delete_departement',

            'sites',
            'add_site',
            'edite_site',
            'delete_site',

            'rays',
            'add_ray',
            'edite_ray',
            'delete_ray',

            'columns',
            'add_column',
            'edite_column',
            'delete_column',

            'shelves',
            'add_shelve',
            'edite_shelve',
            'delete_shelve',
        

            'archive_boxes',

            

            

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web', // Spécifiez le garde ici
            ]);
        }
    }
}