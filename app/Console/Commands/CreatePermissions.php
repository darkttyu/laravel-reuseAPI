<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * This comamnd is used to create permissions and assign them to roles.
 * You can modify the permissions and roles as per your requirements.
 * Only execute this command if the permissions that are required 
 * in your application are finalized, otherwise, you can add other permissions or modify them.
 */
class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Permissions and Assign to Roles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $permissions = [ 
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',  
        ];

        $createdPermissions = [];

        foreach ($permissions as $permission) 
        {
            $createdPermission[] = Permission::create(['name' => $permission]);
        }

        // Assigning Permission to Roles
        $adminRole = Role::findByName('name');
        $userRole = Role::findByName('name');

        /**
         * Assigning roles to permissions via the syncPermissions method
         * It will overwrite the existing permissions for the role.
         * If you want to add more permissions to the role, you can use the givePermissionTo method.
         * If you want to remove a permission from the role, you can use the revokePermissionTo method.
         * If you want to remove all permissions from the role, you can use the syncPermissions method with an empty array.
         * If you want to add a permission to the role, you can use the givePermissionTo method.
         * If you want to remove a permission from the role, you can use the revokePermissionTo method.
         * If you want to remove all permissions from the role, you can use the syncPermissions method with an empty array.
         */
        $adminRole->syncPermissions($createdPermissions);
        $userRole->syncPermissions([]);

        $this->info('Permissions created and assigned to roles.');
    }
}
