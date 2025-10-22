<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:create';

    /**
     * The console command description.
     * 
     * @var string
     */
    protected $description = 'Create Roles.';

    /**
     * Execute the console command.
     * Only execute this command if the roles that are required 
     * in your application are finalized, otherwise, you can add other roles or modify them.
     */
    public function handle()
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);
    }
}
