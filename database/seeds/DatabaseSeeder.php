<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

use BlaudCMS\Permission;
use BlaudCMS\User;
use BlaudCMS\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $output = new ConsoleOutput();
        if ($this->command->confirm('Desea actualizar la migración antes del llenado, borrará todos los datos antiguos ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Datos eliminados, iniciando con una base de datos en blanco.");
        }

        if ($this->command->confirm('Desea generar los permisos por defecto en el sistema ? [Y|n]', true)) {
            // Seed the default permissions
            $this->command->warn('Creando permisos por defecto en el sistema.');

            $bar = new ProgressBar($output, 17);
            $bar->start();
            
            // Permisos para modulo de Autenticacion/Autorizacion
            $this->command->call('permission:backend-permissions', ['name' => 'users']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'roles']);
            $bar->advance();
            print("\n");

            // Permisos para modulo de configuración y parametrización del sistema
            $this->command->call('permission:backend-permissions', ['name' => 'configurations']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'metatags']);
            $bar->advance();
            print("\n");

            // Permisos para administracion de catalogos
            $this->command->call('permission:backend-permissions', ['name' => 'provinces']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'casestages']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'casestagedetails']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'statefunctions']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'institutions']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'officials']);
            $bar->advance();
            print("\n");

            // Permisos para modulo de contenido
            $this->command->call('permission:backend-permissions', ['name' => 'contentcategories']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'contentarticles']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'corruptioncases']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'successstories']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'legallibraries']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'menus']);
            $bar->advance();
            print("\n");
            $this->command->call('permission:backend-permissions', ['name' => 'menuitems']);
            $bar->advance();
            print("\n");

            $this->command->warn('Permisos por defecto agregados.');
            $bar->finish();
            print("\n");
        }

        // Confirm roles needed
        if ($this->command->confirm('Crear Roles para usuarios, por defecto son Super Administrator, Administrator, Editor, Reporter y Visitor? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Ingrese los roles separados por coma.', 'Super Administrator,Administrator,Editor,Reporter,Visitor');

            // Explode roles
            $roles_array = explode(',', $input_roles);
            $bar = new ProgressBar($output, count($roles_array));
            $bar->start();
            // add roles
            foreach($roles_array as $role) {
                $bar->advance();
                print("\n");
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if( $role->name == 'Super Administrator' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('El rol Super Administrator tiene todos los permisos');
                    // Creando un usuario Super Administrator
                    $this->createUser($role);
                }
            }
            $bar->finish();
            print("\n");
            $this->command->info('Roles ' . $input_roles . ' agregados exitosamente');

        } else {
            $role = Role::firstOrCreate(['name' => 'Super Administrator']);
            $role->syncPermissions(Permission::all());
            $this->createUser($role);
            $this->command->info('Agregado el rol de Super Administrator unicamente.');
        }

        if ($this->command->confirm('Desea cargar los catalogos por defecto en el sistema ? [Y|n]', true)) {
            // Seed the default permissions
            $this->command->warn('Cargando catalogos en el sistema.');
            
            $this->call(CatalogsTableSeeder::class);
            print("\n");
            $this->command->warn('Catalogos cargados.');
        }

        // Confirm menu
        if ($this->command->confirm('Crear Menú Principal Superior? [y|N]', false)) {
            $this->command->call('menu:manage', ['name' => 'Menu Principal Superior', 'position' => 'top', '--create' => true]);
        }
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        
        $adminUserName = $this->command->ask('Ingrese el nombre del usuario Super Administrador', 'Administrador');
        $adminUserLastame = $this->command->ask('Ingrese el apellido del usuario Super Administrador', 'BlaudCMS');
        $adminUserEmail = $this->command->ask('Ingrese el email del usuario Super Administrador', 'admin@blaudcms.com');

        $banPass = 0;
        while ($banPass == 0) {
            $adminUserPassword = $this->command->secret('Ingrese el password del usuario.');
            $adminUserConfirmPassword = $this->command->secret('Confirme el password del usuario');
            if($adminUserPassword && ($adminUserPassword === $adminUserConfirmPassword)){
                $banPass = 1;
            }else{
                $this->warn('El password y la confirmacion no coinciden, por favor ingreselos nuevamente.');
            }
        }

        $oUser = new User;
        $oUser->name = $adminUserName;
        $oUser->lastname = $adminUserLastame;
        $oUser->email = $adminUserEmail;
        $oUser->password = $adminUserPassword;
        $oUser->temporary_password = $adminUserPassword;
        $oUser->type = 'S';
        $oUser->status = 1;
        $oUser->avatar = '';
        if($oUser->save()){
            $oUser->assignRole($role);
            if( $role->name == 'Super Administrator' ) {
                $this->command->info('El usuario Super Administrator ha sido creado exitosamente.');
            }
        }else{
            $this->command->error('Lo sentimos. El usuario Super Administrator No pudo ser creado.');
        }
    }
}
