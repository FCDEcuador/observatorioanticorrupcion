<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateConfigurationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $output = new ConsoleOutput();
        $bar = new ProgressBar($output, 3);
        $bar->start();

        if(!Schema::hasTable('configurations')){
            Schema::create('configurations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_website')->nullable()->default('Observatorio :: Home'); // campo para etiqueta <title> de home
                $table->string('facebook_account')->nullable();
                $table->string('twitter_account')->nullable();
                $table->string('instagram_account')->nullable();
                $table->string('googleplus_account')->nullable();
                $table->string('pinterest_account')->nullable();
                $table->string('linkedin_account')->nullable();
                $table->string('youtube_account')->nullable();
                $table->string('vimeo_account')->nullable();
                $table->text('google_analytics_script')->nullable();
                $table->text('another_mark_top_script')->nullable();
                $table->text('another_mark_bottom_script')->nullable();
                $table->text('advertising_top_script')->nullable();
                $table->text('advertising_positions')->nullable();
                $table->text('advertising_bottom_script')->nullable();
                $table->text('add_this_script')->nullable();
                $table->text('disqus_script')->nullable();
                $table->string('contact_map_coordinates')->nullable();
                $table->string('contact_emails')->nullable();
                $table->string('sales_emails')->nullable();
                $table->string('admin_email')->nullable();
                $table->string('backend_logo')->nullable();
                $table->timestamps();
            });
        }
        $bar->advance();

        if(!Schema::hasTable('meta_tags')){
            Schema::create('meta_tags', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name');
                $table->string('type');
                $table->string('value')->nullable();
                $table->text('extra_attributes')->nullable();
                $table->timestamps();
                $table->primary('id');
            });
        }
        $bar->advance();

        if(!Schema::hasTable('catalogs')){
            Schema::create('catalogs', function (Blueprint $table) {
                $table->uuid('id');
                $table->text('context');
                $table->string('code')->nullable();
                $table->string('description')->nullable();
                $table->text('coordinates')->nullable();
                $table->string('string_value1', 100)->nullable();
                $table->string('string_value2', 100)->nullable();
                $table->string('long_string_value1', 300)->nullable();
                $table->string('long_string_value2', 300)->nullable();
                $table->text('text_value1')->nullable();
                $table->text('text_value2')->nullable();
                $table->boolean('boolean_value1')->nullable();
                $table->boolean('boolean_value2')->nullable();
                $table->boolean('boolean_value3')->nullable();
                $table->integer('integer_value1')->nullable();
                $table->integer('integer_value2')->nullable();
                $table->integer('integer_value3')->nullable();
                $table->decimal('decimal_value1', 18,2)->nullable();
                $table->decimal('decimal_value2', 18,2)->nullable();
                $table->decimal('decimal_value3', 18,2)->nullable();
                $table->date('date_value1')->nullable();
                $table->date('date_value2')->nullable();
                $table->time('time_value1')->nullable();
                $table->time('time_value2')->nullable();
                $table->datetime('datetime_value1')->nullable();
                $table->datetime('datetime_value2')->nullable();
                $table->string('father_code')->nullable();
                $table->string('father_description')->nullable();
                $table->uuid('catalogue_id')->nullable();
                $table->timestamps();
                $table->primary('id');
                $table->foreign('catalogue_id')->references('id')->on('catalogs');
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
        $bar = new ProgressBar($output, 3);
        $bar->start();

        Schema::dropIfExists('catalogs');
        $bar->advance();
        Schema::dropIfExists('meta_tags');
        $bar->advance();
        Schema::dropIfExists('configurations');
        $bar->advance();

        $bar->finish();
        print("\n");
    }
}
