<?php
namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Spatie\Permission\Models\Role;

    class RoleSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $role = Role::create(['name' => 'Admin']);

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

                $role->permissions()->attach($id, [
                    'create' => $create,
                    'read' => $read,
                    'update' => $update,
                    'delete' => $delete
                ]);
            }
        }
    }
