<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $output = new ConsoleOutput();
        $bar = new ProgressBar($output, 7);
        $bar->start();

        if( ! Schema::hasTable('corruption_cases')){
            Schema::create('corruption_cases', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('case_stage', 200)->nullable();
                $table->string('case_stage_detail', 200)->nullable();
                $table->string('province')->nullable();
                $table->string('state_function')->nullable();
                $table->string('tags')->nullable();
                $table->integer('involved_number')->default(0);
                $table->text('linked_institutions')->nullable();
                $table->text('public_officials_involved')->nullable();
                $table->string('main_multimedia')->nullable();
                $table->string('home_image')->nullable();
                $table->string('title')->unique();
                $table->string('slug')->unique();
                $table->text('summary')->nullable();
                $table->text('history')->nullable();
                $table->text('history_image')->nullable();
                $table->text('legal_causes')->nullable();
                $table->text('political_causes')->nullable();
                $table->text('consequences_introduction')->nullable();
                $table->text('consequences_title')->nullable();
                $table->text('consequences_description')->nullable();
                $table->text('economic_consequences')->nullable();
                $table->text('social_consequences')->nullable();
                $table->text('sources')->nullable();
                $table->text('consequences_image')->nullable();
                $table->timestamps();
                $table->primary('id');
            });
        }
        $bar->advance();


        if( ! Schema::hasTable('what_happened')){
            Schema::create('what_happened', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('year')->nullable();
                $table->string('month')->nullable();
                $table->string('day')->nullable();
                $table->text('description')->nullable();
                $table->integer('order')->default(1);
                $table->uuid('corruption_case_id')->nullable();
                $table->timestamps();
                $table->primary('id');
                $table->foreign('corruption_case_id')->references('id')->on('corruption_cases');
            });
        }
        $bar->advance();

        if(!Schema::hasTable('success_stories')){
            Schema::create('success_stories', function(Blueprint $table){
                $table->uuid('id');
                $table->string('name')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('description')->nullable();
                $table->string('image')->nullable();
                $table->string('icon')->nullable();
                $table->string('url');
                $table->timestamps();
                $table->primary('id');
            });
        }
        $bar->advance();


        if( ! Schema::hasTable('content_categories')){
            Schema::create('content_categories', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->text('tags')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->text('extra_headers')->nullable();
                $table->uuid('content_category_id')->nullable();
                $table->timestamps();
                $table->primary('id');
                $table->foreign('content_category_id')->references('id')->on('content_categories');
            });
        }
        $bar->advance();


        if(!Schema::hasTable('content_articles')){
            Schema::create('content_articles', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('title')->unique();
                $table->string('slug')->unique();
                $table->string('summary');
                $table->text('content')->nullable();
                $table->string('author')->nullable();
                $table->string('author_email')->nullable();
                $table->string('source')->nullable();
                $table->text('tags')->nullable();
                $table->text('main_multimedia')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->text('extra_headers')->nullable();
                $table->boolean('outstanding')->default(0);
                $table->boolean('main_category')->default(0);
                $table->boolean('main_home')->default(0);
                $table->uuid('content_category_id')->nullable();
                $table->timestamps();
                $table->primary('id');
                $table->foreign('content_category_id')->references('id')->on('content_categories');
            });
        }
        $bar->advance();

        if(!Schema::hasTable('menus')){
            Schema::create('menus', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name')->unique();
                $table->string('position');
                $table->boolean('active')->default(1);
                $table->timestamps();
                $table->primary('id');
            });
        }
        $bar->advance();

        if(!Schema::hasTable('menu_items')){
            Schema::create('menu_items', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name');
                $table->string('title')->nullable();
                $table->string('summary')->nullable();
                $table->string('image')->nullable();
                $table->string('icon')->nullable();
                $table->text('link');
                $table->char('type', 1)->default('I');
                /*
                    I -> interno
                    E -> externo
                */
                $table->string('target')->default('_self');
                /*
                    _self
                    _blank
                */
                $table->integer('level')->default(0);
                $table->integer('order')->default(0);
                $table->boolean('active')->default(1);
                $table->uuid('menu_item_id')->nullable();
                $table->uuid('menu_id');
                $table->timestamps();
                $table->primary('id');
                $table->foreign('menu_item_id')->references('id')->on('menu_items');
                $table->foreign('menu_id')->references('id')->on('menus');
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
        $bar = new ProgressBar($output, 7);
        $bar->start();
        
        Schema::dropIfExists('menu_items');
        $bar->advance();
        Schema::dropIfExists('menus');
        $bar->advance();
        Schema::dropIfExists('content_articles');
        $bar->advance();
        Schema::dropIfExists('content_categories');
        $bar->advance();
        Schema::dropIfExists('success_stories');
        $bar->advance();
        Schema::dropIfExists('what_happened');
        $bar->advance();
        Schema::dropIfExists('corruption_cases');
        $bar->advance();

        $bar->finish();
        print("\n");
    }
}
