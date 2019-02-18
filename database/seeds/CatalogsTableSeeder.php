<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

use BlaudCMS\Catalogue;

class CatalogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$output = new ConsoleOutput();
        $bar = new ProgressBar($output, 242);

        $bar->start();
        // PROVINCIAS Y CIUDADES POR PROVINCIA

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '1';
        $oProvince->description = 'Azuay';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Camilo Ponce';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chordeleg';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cuenca';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Pan';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Giron';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Guachapala';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Gualaceo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-08';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Nabon';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-09';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Oña';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-10';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Paute';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-11';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pucara';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-12';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Fernando';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-13';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Isabel';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-14';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sevilla de Oro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '01-15';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sigsig';
	        $oCity->save();
	        $bar->advance();
        }

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '2';
        $oProvince->description = 'Bolivar';
        $oProvince->string_value1 = '03';
        if($oProvince->save()){
        	$bar->advance();
        	
        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-01';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Caluma';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-02';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chillanes';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-03';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chimbo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-04';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Echeandia';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-05';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Guaranda';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-06';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Las Naves';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '02-07';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Miguel';
	        $oCity->save();
	        $bar->advance();
        }

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '3';
        $oProvince->description = 'Cañar';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Azogues';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Biblan';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cañar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Deleg';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'La Troncal';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Suscal';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '03-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Tambo';
	        $oCity->save();
	        $bar->advance();
        }

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '4';
        $oProvince->description = 'Carchi';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Bolivar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Espejo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Mira';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Montufar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-05';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Pedro de Huaca';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '04-06';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Tulcan';
	        $oCity->save();
	        $bar->advance();
        }

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '6';
        $oProvince->description = 'Chimborazo';
        $oProvince->string_value1 = '03';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-01';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Alausi';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-02';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chambo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-03';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chunchi';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-04';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Colta';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-05';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cumanda';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-06';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Guamote';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-07';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Guano';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-08';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Papallacta';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-09';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Penipe';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '06-10';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Riobamba';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '5';
        $oProvince->description = 'Cotopaxi';
        $oProvince->string_value1 = '03';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-01';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'La Mana';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-02';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Latacunga';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-03';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pangua';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-04';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pujili';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-05';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Salcedo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-06';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Saquisili';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '05-07';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sigchos';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '7';
        $oProvince->description = 'El Oro';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Arenillas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Atahualpa';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Balsas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chilla';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Guabo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Huaquillas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Las Lajas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-08';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Machala';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-09';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Marcabeli';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-10';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pasaje';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-11';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Piñas';
	        $oCity->save();
	        $bar->advance(); //70
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-12';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Portovelo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-13';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Rosa';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '07-14';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Zaruma';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '8';
        $oProvince->description = 'Esmeraldas';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Atacames';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Eloy Alfaro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Esmeraldas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Muisne';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-05';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quininde';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-06';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Rio Verde';
	        $oCity->save();
	        $bar->advance(); //80
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '08-07';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Lorenzo';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '20';
        $oProvince->description = 'Galapagos';
        $oProvince->string_value1 = '05';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '20-01';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Isabela';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '20-02';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Cristobal';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '20-03';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Cruz';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '9';
        $oProvince->description = 'Guayas';
        $oProvince->string_value1 = '04';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-01';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Alfredo Baquerizo Moreno (Jujan)';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-02';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Balao';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-03';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Balzar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-04';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Colimes';
	        $oCity->save();
	        $bar->advance(); //90
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-05';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Daule';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-06';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Duran';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-07';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Triunfo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-08';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Empalme';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-09';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'General Antonio Elizalde (Bucay)';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-10';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'General Villamil (Playas)';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-11';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Guayaquil';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-12';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Isidro Ayora';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-13';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Lomas de Sargentillo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-14';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Marcelino Maridueña';
	        $oCity->save();
	        $bar->advance(); //100
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-15';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Milagro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-16';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Naranjal';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-17';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Naranjito';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-18';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Nobol (Narcisa de Jesus)';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-19';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Palestina';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-20';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pedro Carbo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-21';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Samborondon';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-22';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Lucia';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-23';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Simon Bolivar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-24';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Urbina Jado (Salitre)';
	        $oCity->save();
	        $bar->advance(); //110
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '09-25';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Yaguachi';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '10';
        $oProvince->description = 'Imbabura';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Atuntaqui (Antonio Ante)';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cotacachi';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Ibarra';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Otavalo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-05';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pimampiro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '10-06';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Urcuqui';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '11';
        $oProvince->description = 'Loja';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Calvas (Cariamanga)';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Catamayo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Celica';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chaguarpamba';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Espindola';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Gonzanama';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Loja';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-08';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Macara';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-09';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Olmedo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-10';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Paltas (Catacocha)';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-11';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pindal';
	        $oCity->save();
	        $bar->advance(); //130

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-12';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Puyango (Alamor)';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-13';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quilanga';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-14';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Saraguro';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-15';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sozoranga';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '11-16';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Zapotillo';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '12';
        $oProvince->description = 'Los Rios';
        $oProvince->string_value1 = '05';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-01';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Baba';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-02';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Babahoyo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-03';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Buena Fe';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-04';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Mocache';
	        $oCity->save();
	        $bar->advance(); //140

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-05';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Montalvo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-06';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Palenque';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-07';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pueblo Viejo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-08';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quevedo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-09';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Urdaneta';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-10';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Valencia';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-11';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Ventanas';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '12-12';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Vinces';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '13';
        $oProvince->description = 'Manabi';
        $oProvince->string_value1 = '05';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-01';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = '24 de Mayo';
	        $oCity->save();
	        $bar->advance(); //150
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-02';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Bolivar';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-03';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chone';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-04';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Carmen';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-05';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Flavio Alfaro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-06';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Jama';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-07';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Jaramillo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-08';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Jipijapa';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-09';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Junin';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-10';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Manta';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-11';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Montecristi';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-12';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Olmedo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-13';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pajan';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-14';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pichincha';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-15';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Puerto Lopez';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-16';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pedernales';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-17';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Portoviejo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-18';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Rocafuerte';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-19';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Vicente';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-20';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Ana';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-21';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sucre';
	        $oCity->save();
	        $bar->advance(); //170
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '13-22';
	        $oCity->string_value1 = '05';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Tosagua';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '14';
        $oProvince->description = 'Morona Santiago';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Gualaquiza';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Huamboya';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Limon-Indanza';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Logroño';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Morona';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pablo VI';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Palora';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-08';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Juan Bosco';
	        $oCity->save();
	        $bar->advance(); //180
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-09';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santiago';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-10';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sucua';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-11';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Taisha';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '14-12';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Twintza';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '15';
        $oProvince->description = 'Napo';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '15-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Archidona';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '15-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Carlos J. Arosemena Tola';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '15-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Chaco';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '15-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quijos';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '15-05';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Tena';
	        $oCity->save();
	        $bar->advance(); //190
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '22';
        $oProvince->description = 'Orellana';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '22-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Aguarico';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '22-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'La Joya de los Sachas';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '22-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Loreto';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '22-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Orellana';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '16';
        $oProvince->description = 'Pastaza';
        $oProvince->string_value1 = '03';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '16-01';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Arajuno';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '16-02';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Mera';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '16-03';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pastaza';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '16-04';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Clara';
	        $oCity->save();
	        $bar->advance(); //200
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '17';
        $oProvince->description = 'Pichincha';
        $oProvince->string_value1 = '02';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-01';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cayambe';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-02';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Mejia';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-03';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pedro Moncayo';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-04';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Pedro Vicente Maldonado';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-05';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Puerto Quito';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-06';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quito';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-07';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Rumiñahui';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '17-08';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Miguel de los Bancos';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '24';
        $oProvince->description = 'Santa Elena';
        $oProvince->string_value1 = '04';
        if($oProvince->save()){
        	$bar->advance(); //210

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '24-01';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'La Libertad';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '24-02';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Salinas';
	        $oCity->save();
	        $bar->advance();

	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '24-03';
	        $oCity->string_value1 = '04';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santa Elena';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '23';
        $oProvince->description = 'Santo Domingo de los Tsáchilas';
        $oProvince->string_value1 = '02';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '23-01';
	        $oCity->string_value1 = '02';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santo Domingo de los Tsáchilas';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '21';
        $oProvince->description = 'Sucumbios';
        $oProvince->string_value1 = '06';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-01';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cascales';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-02';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cuyabeno';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-03';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Gonzalo Pizarro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-04';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Lago Agrio';
	        $oCity->save();
	        $bar->advance(); //220
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-05';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Putumayo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-06';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Shushufindi';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '21-07';
	        $oCity->string_value1 = '06';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Sucumbios';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '18';
        $oProvince->description = 'Tungurahua';
        $oProvince->string_value1 = '03';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-01';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Ambato';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-02';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Baños de Agua Santa';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-03';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Cevallos';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-04';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Mocha';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-05';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Patate';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-06';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Quero';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-07';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'San Pedro de Pelileo';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-08';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Santiago de Pillaro';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '18-09';
	        $oCity->string_value1 = '03';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Tisaleo';
	        $oCity->save();
	        $bar->advance();
        }
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '19';
        $oProvince->description = 'Zamora Chinchipe';
        $oProvince->string_value1 = '07';
        if($oProvince->save()){
        	$bar->advance();

        	$oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-01';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Centinela del Condor';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-02';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Chinchipe';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-03';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'El Pangui';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-04';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Nangaritza';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-05';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Palanda';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-06';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Yacuambi';
	        $oCity->save();
	        $bar->advance(); //240
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-07';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Yantzaza';
	        $oCity->save();
	        $bar->advance();
	        
	        $oCity = new Catalogue;
	        $oCity->catalogue_id = $oProvince->id;
	        $oCity->context = 'Ciudades';
	        $oCity->code = '19-08';
	        $oCity->string_value1 = '07';
	        $oCity->father_code = $oProvince->code;
	        $oCity->father_description = $oProvince->description;
	        $oCity->description = 'Zamora';
	        $oCity->save();
	        $bar->advance();
        }
        $bar->finish();
    }
}
