<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Rathan',
            'last_name' => 'Poudel',
            'email' => 'rathan@admin.com',
            'username' => 'rathan406',
            'password' => Hash::make('rathan406'),
            'phone' => '0987654321',
            'address' => 'Yangon',
        ]);
        $admin->assignRole('Admin');
        // Permission::create(['name' => 'posts.create,read,update,delete']);
        // $admin->givePermissionTo('posts.create,read,update,delete');
        $rolePermissions = [
            [
                'permission_id' => '1',
                'name' => 'Category',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '2',
                'name' => 'Subcategory',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '3',
                'name' => 'User',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '4',
                'name' => 'Permission',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '5',
                'name' => 'Role-Permission',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '6',
                'name' => 'User-Role-Permission',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '7',
                'name' => 'Dashboard',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],
            [
                'permission_id' => '8',
                'name' => 'Order',
                'create' => 'yes',
                'read' => 'yes',
                'update' => 'yes',
                'delete' => 'yes'
            ],

        ];
        foreach ($rolePermissions as $rolePermission) {
            $id = $rolePermission['permission_id'];
            $create = $rolePermission['create'];
            $read = $rolePermission['read'];
            $update = $rolePermission['update'];
            $delete = $rolePermission['delete'];

            $admin->permissions()->attach($id, [
                'create' => $create,
                'read' => $read,
                'update' => $update,
                'delete' => $delete
            ]);
        }
    }
}
