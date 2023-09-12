<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RNPseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin_permission = [

            // Web Page Accessble
            'dashboard.page.enabled',
            'dashboard.config.enabled',
            'dashboard.users.table.enabled',
            'dashboard.users.activity.enabled',
            'dashboard.web.log.enabled',
            'dashboard.notification.enabled',
            'dashboard.show.profile.enabled',
            'dashboard.edit.profile.enabled',
            'dashboard.show.account.activity.enabled',

            /**
             *   Web Features Allowed
             */

            // (2) user related features
            'dashboard.user.add.enabled',
            'dashboard.user.block.enabled',
            'dashboard.user.remove.enabled',
            'dashboard.user.edit.enabled',

        ];


        $role_has_permission = [
            'admin' =>  $admin_permission,
            'user' => [],
        ];

        foreach ($role_has_permission as $role_ => $permissions) {

            $role   =   Role::create(['name' => $role_]);

            foreach ($permissions as $_permission)

                if ($role instanceof Role) {

                    $permission = Permission::findOrCreate($_permission);

                    $role->givePermissionTo($permission);

                    // ...
                }
        }

        // create high admin role & granted all permissions to its role
        $role = Role::create(['name' => 'supreme']);
        $role->givePermissionTo(Permission::all());
    }
}
