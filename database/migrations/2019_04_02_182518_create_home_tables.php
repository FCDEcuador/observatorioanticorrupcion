<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateHomeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $output = new ConsoleOutput();
        $bar = new ProgressBar($output, 2);
        $bar->start();

        if( ! Schema::hasTable('main_sliders')){
            Schema::create('main_sliders', function (Blueprint $table) {
                $table->uuid('id');
                $table->integer('order');
                $table->string('image_path', 200);
                $table->boolean('status')->default(1);
                $table->timestamps();
                $table->primary('id');
            });
        }
        $bar->advance();


        if( ! Schema::hasTable('home_fields')){
            Schema::create('home_fields', function (Blueprint $table) {
                $table->increments('id');
                $table->text('legal_library_text')->nullable();
                $table->string('legal_library_image')->nullable();
                $table->text('success_stories_title')->nullable();
                $table->text('success_stories_text')->nullable();
                $table->timestamps();
            });
        }
        $bar->advance();


        $bar->finish();
        print("\n");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $output = new ConsoleOutput();
        $bar = new ProgressBar($output, 2);
        $bar->start();
        
        Schema::dropIfExists('home_fields');
        $bar->advance();
        Schema::dropIfExists('main_sliders');
        $bar->advance();

        $bar->finish();
        print("\n");
    }
}
