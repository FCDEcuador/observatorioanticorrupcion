<?php

namespace BlaudCMS\Console\Commands;

use Illuminate\Console\Command;

use BlaudCMS\Permission;
use BlaudCMS\Role;

class AuthBackendPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:backend-permissions {name} {--R|remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Administración de permisos para el backend del sistema.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = $this->generatePermissions();

        // check if its remove
        if( $is_remove = $this->option('remove') ) {
            // remove permission
            if( Permission::where('name', 'LIKE', '%'. $this->getNameArgument())->delete() ) {
                $this->info('Permiso(s) ' . implode(', ', $permissions) . ' eliminado(s).');
            }  else {
                $this->warn('No se encontraron permisos para: ' . $this->getNameArgument());
            }
        } else {
            // create permissions
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission ]);
            }
            $this->info('Permiso(s) ' . implode(', ', $permissions) . ' creado(s).');
        }

        // sync role for admin
        if( $oRole = Role::where('name', 'Super Administrator')->first() ) {
            $oRole->syncPermissions(Permission::all());
            $this->info('Permisos de Super Administrador sincronizados.');
        }
    }

    private function generatePermissions()
    {
        $abilities = ['view', 'add', 'edit', 'delete'];
        $name = $this->getNameArgument();

        return array_map(function($val) use ($name) {
            return 'backend_' . $val . '_'. $name;
        }, $abilities);
    }

    private function getNameArgument()
    {
        return strtolower(str_plural($this->argument('name')));
    }
}
