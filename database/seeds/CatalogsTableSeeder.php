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
        $bar = new ProgressBar($output, 45);

        $bar->start();

        /*************************************************************************

        		ETAPAS DEL CASO Y DETALLES DE ETAPA DEL CASO

        *************************************************************************/

        $oCaseStage = new Catalogue;
        $oCaseStage->context = 'Etapa Actual del Caso';
        $oCaseStage->code = '1';
        $oCaseStage->description = 'Examen de Contraloría';
        if($oCaseStage->save()){
        	$bar->advance();

        	$oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '1';
	        $oCaseStageDetail->description = 'Auditoría';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '2';
	        $oCaseStageDetail->description = 'Informe borrador con personas vinculadas';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '3';
	        $oCaseStageDetail->description = 'Determinación de responsabilidades civiles';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '4';
	        $oCaseStageDetail->description = 'Determinación de responsabilidades civiles penales';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();
        }


        $oCaseStage = new Catalogue;
        $oCaseStage->context = 'Etapa Actual del Caso';
        $oCaseStage->code = '2';
        $oCaseStage->description = 'Proceso Judicial';
        if($oCaseStage->save()){
        	$bar->advance();

        	$oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '1';
	        $oCaseStageDetail->description = 'Investigación judicial';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '2';
	        $oCaseStageDetail->description = 'Archivo del caso';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '3';
	        $oCaseStageDetail->description = 'Juicio';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '4';
	        $oCaseStageDetail->description = 'Sobreseimiento';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '5';
	        $oCaseStageDetail->description = 'Sentencia de responsabilidad penal';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '6';
	        $oCaseStageDetail->description = 'Sentencia de declaración de inocencia';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();

	        $oCaseStageDetail = new Catalogue;
	        $oCaseStageDetail->context = 'Detalle sobre la Etapa';
	        $oCaseStageDetail->code = '7';
	        $oCaseStageDetail->description = 'Sanción';
	        $oCaseStageDetail->catalogue_id = $oCaseStage->id;
	        $oCaseStageDetail->save();
	        $bar->advance();
	    }

	    $oCaseStage = new Catalogue;
        $oCaseStage->context = 'Etapa Actual del Caso';
        $oCaseStage->code = '3';
        $oCaseStage->description = 'Investigación periodística';
        $oCaseStage->save();
    	$bar->advance();


    	/*************************************************************************

        		FUNCIONES DEL ESTADO

        *************************************************************************/

        $oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->code = '1';
        $oStateFunction->description = 'Función Legislativa';
        $oStateFunction->save();
    	$bar->advance();

    	$oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->code = '2';
        $oStateFunction->description = 'Función Ejecutiva';
        $oStateFunction->save();
    	$bar->advance();

    	$oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->code = '3';
        $oStateFunction->description = 'Función Judicial';
        $oStateFunction->save();
    	$bar->advance();

    	$oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->code = '4';
        $oStateFunction->description = 'Función Electoral';
        $oStateFunction->save();
    	$bar->advance();

    	$oStateFunction = new Catalogue;
        $oStateFunction->context = 'Función del Estado';
        $oStateFunction->code = '5';
        $oStateFunction->description = 'Función de Transparencia y Control Social';
        $oStateFunction->save();
    	$bar->advance();


    	/*************************************************************************

        		INSTITUCIONES

        *************************************************************************/
        
        $oInstitution = new Catalogue;
        $oInstitution->context = 'Instituciones';
        $oInstitution->code = '1';
        $oInstitution->description = 'Congreso Nacional';
        $oInstitution->save();
    	$bar->advance();

    	/*************************************************************************

        		FUNCIONARIOS

        *************************************************************************/
        
        $oOfficial = new Catalogue;
        $oOfficial->context = 'Funcionarios';
        $oOfficial->code = '1';
        $oOfficial->description = 'Fabián Alarcón';
        $oOfficial->save();
    	$bar->advance();
        
        /*************************************************************************

        		PROVINCIAS

        *************************************************************************/

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '1';
        $oProvince->description = 'Azuay';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '2';
        $oProvince->description = 'Bolivar';
        $oProvince->string_value1 = '03';
        $oProvince->save();
        $bar->advance();

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '3';
        $oProvince->description = 'Cañar';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '4';
        $oProvince->description = 'Carchi';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();

        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '6';
        $oProvince->description = 'Chimborazo';
        $oProvince->string_value1 = '03';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '5';
        $oProvince->description = 'Cotopaxi';
        $oProvince->string_value1 = '03';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '7';
        $oProvince->description = 'El Oro';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '8';
        $oProvince->description = 'Esmeraldas';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '20';
        $oProvince->description = 'Galapagos';
        $oProvince->string_value1 = '05';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '9';
        $oProvince->description = 'Guayas';
        $oProvince->string_value1 = '04';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '10';
        $oProvince->description = 'Imbabura';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '11';
        $oProvince->description = 'Loja';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '12';
        $oProvince->description = 'Los Rios';
        $oProvince->string_value1 = '05';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '13';
        $oProvince->description = 'Manabi';
        $oProvince->string_value1 = '05';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '14';
        $oProvince->description = 'Morona Santiago';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '15';
        $oProvince->description = 'Napo';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '22';
        $oProvince->description = 'Orellana';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '16';
        $oProvince->description = 'Pastaza';
        $oProvince->string_value1 = '03';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '17';
        $oProvince->description = 'Pichincha';
        $oProvince->string_value1 = '02';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '24';
        $oProvince->description = 'Santa Elena';
        $oProvince->string_value1 = '04';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '23';
        $oProvince->description = 'Santo Domingo de los Tsáchilas';
        $oProvince->string_value1 = '02';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '21';
        $oProvince->description = 'Sucumbios';
        $oProvince->string_value1 = '06';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '18';
        $oProvince->description = 'Tungurahua';
        $oProvince->string_value1 = '03';
        $oProvince->save();
        $bar->advance();
        
        $oProvince = new Catalogue;
        $oProvince->context = 'Provincias';
        $oProvince->code = '19';
        $oProvince->description = 'Zamora Chinchipe';
        $oProvince->string_value1 = '07';
        $oProvince->save();
        $bar->advance();

        $bar->finish();
    }
}
