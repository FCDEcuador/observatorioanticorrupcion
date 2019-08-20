<?php

namespace BlaudCMS\Console\Commands;

use Illuminate\Console\Command;

use BlaudCMS\Menu;
use BlaudCMS\MenuItem;

class ContentMenusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:manage 
                            {name : Nombre del menu a crear} 
                            {position? : Posicion del menu a crear (top, left, right, bottom, middle)} 
                            {--C|create : Escriba esta opcion para crear un nuevo menu} 
                            {--R|remove : Escriba esta opcion para eliminar un menu} 
                            {--S|change-status : Escriba esta opcion para cambiar el estado (activar/desactivar) de un menu}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creacion, eliminacion, activacion o desactivacion de menus para el gestor de contenido.';

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
        // check if its remove
        if( $is_remove = $this->option('remove') ) {
            // remove menu
            if( Menu::where('name', $this->argument('name'))->delete() ) {
                $this->info('Menu ' . $this->argument('name') . ' eliminado.');
            }  else {
                $this->warn('No se encontró ningun menu con el nombre: ' . $this->argument('name'));
            }
        } elseif ( $is_change_status = $this->option('change-status') ) {
            // change menu status
            $oMenu = Menu::where('name', $this->argument('name'))->first();
            if( $oMenu ) {
                $newStatus = $oMenu->active == 1 ? 0 : 1;
                $oMenu->active = $newStatus;
                if($oMenu->save()){
                    $this->info('Se ha cambiado exitosamente el estado del menu ' . $this->argument('name') . '.');
                }else{
                    $this->info('El estado del menu ' . $this->argument('name') . ' no pudo ser cambiado.');
                }
            }  else {
                $this->warn('No se encontró ningun menu con el nombre: ' . $this->argument('name'));
            }
        }elseif ( $is_create = $this->option('create') ) {
            // create menu
            if( ! $this->argument('position')){
                $position = 'top';
            }else{
                $position = $this->argument('position');
            }

            $oMenu = new Menu;
            $oMenu->name = $this->argument('name');
            $oMenu->position = $position;
            $oMenu->active = 1;

            if($oMenu->save()){
                $this->info($oMenu->name . ' creado exitosamente.');

                $oMenuItem = new MenuItem;
                $oMenuItem->name = 'Home';
                $oMenuItem->title = 'Home';
                $oMenuItem->summary = '';
                $oMenuItem->image = '';
                $oMenuItem->icon = '';
                $oMenuItem->link = '/';
                $oMenuItem->type = 'I';
                $oMenuItem->target = '_self';
                $oMenuItem->level = 0;
                $oMenuItem->order = 0;
                $oMenuItem->active = 1;
                $oMenuItem->menu_item_id = null;
                $oMenuItem->menu_id = $oMenu->id;
                $oMenuItem->save();

                $this->info('Item ' . $oMenuItem->name . ' creado exitosamente para ' . $oMenu->name);
            }else{
                $this->error('Menu ' . $oMenu->name . ' no pudo ser creado.');
            }
        }else{
            $this->warn('Por favor ingrese la opcion que se desea realizar con este menu: --create | --remove | --change-status');
        }
    }
}
