<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cuts')){
            Schema::create('cuts', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->integer('width');
                $table->integer('height');
                $table->boolean('active')->default(1);
                $table->timestamps();
                $table->primary('id');
            });
        }

        if(!Schema::hasTable('content_categories')){
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
                $table->boolean('active')->default(1);
                $table->integer('num_list_items')->default(1);
                $table->text('advertising_positions')->nullable();
                $table->integer('hits')->default(0);
                $table->uuid('content_category_id')->nullable();
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamps();
                $table->primary('id');
                $table->foreign('content_category_id')->references('id')->on('content_categories');
            });
        }


        if(!Schema::hasTable('multimedia_contents')){
            Schema::create('multimedia_contents', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('author')->nullable();
                $table->string('author_email')->nullable();
                $table->integer('content_type')->default(1);
                /*
                    1 -> Archivo
                    2 -> Audio
                    3 -> Galerias de Imagenes/Videos
                    4 -> HTML libre
                    5 -> Imagen
                    6 -> Video
                */
                $table->string('name')->unique();
                $table->string('slug')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('geolocation')->nullable();
                $table->string('file')->nullable();
                $table->string('audio')->nullable();
                $table->text('gallery_items')->nullable();
                $table->text('free_html')->nullable();
                $table->string('image')->nullable();
                $table->text('video')->nullable();
                $table->boolean('active')->default(1);
                $table->integer('sum_votes')->default(0);
                $table->integer('total_votes')->default(0);
                $table->integer('hits')->default(0);
                $table->text('tags')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->text('extra_headers')->nullable();
                $table->uuid('content_category_id')->nullable();
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamps();
                $table->primary('id');
                $table->foreign('content_category_id')->references('id')->on('content_categories');
            });
        }


        if(!Schema::hasTable('content_articles')){
            Schema::create('content_articles', function (Blueprint $table) {
                $table->uuid('id');
                $table->char('content_type', 1)->default('A');
                /*
                    A -> Articulo
                    S -> Pagina estatica
                */
                $table->string('title')->unique();
                $table->string('short_title')->unique();
                $table->string('slug')->unique();
                $table->string('summary');
                $table->text('content')->nullable();
                $table->integer('state')->default(1);
                $table->datetime('publication_date')->nullable();
                $table->datetime('release_date')->nullable();
                $table->string('author')->nullable();
                $table->string('author_email')->nullable();
                $table->string('source')->nullable();
                $table->integer('sum_votes')->default(0);
                $table->integer('total_votes')->default(0);
                $table->integer('hits')->default(0);
                $table->text('tags')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->text('extra_headers')->nullable();
                $table->boolean('outstanding')->default(0);
                $table->boolean('main_category')->default(0);
                $table->boolean('main_home')->default(0);
                $table->uuid('content_category_id')->nullable();
                $table->string('created_by');
                $table->string('updated_by');
                $table->timestamps();
                $table->primary('id');
                $table->foreign('content_category_id')->references('id')->on('content_categories');
            });
        }


        if(!Schema::hasTable('article_multimedias')){
            Schema::create('article_multimedias', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('path');
                $table->boolean('main_content')->default(0);
                $table->boolean('list_image')->default(0);
                $table->uuid('multimedia_content_id');
                $table->uuid('content_article_id');
                $table->uuid('cut_id')->nullable();
                $table->timestamps();
                $table->primary('id');
                $table->foreign('multimedia_content_id')->references('id')->on('multimedia_contents');
                $table->foreign('content_article_id')->references('id')->on('content_articles');
                $table->foreign('cut_id')->references('id')->on('cuts');
            });
        }

        if(!Schema::hasTable('menus')){
            Schema::create('menus', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('name')->unique();
                $table->integer('position')->default(1);
                $table->boolean('active')->default(1);
                $table->timestamps();
                $table->primary('id');
            });
        }

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

        if(!Schema::hasTable('external_links')){
            Schema::create('external_links', function(Blueprint $table){
                $table->uuid('id');
                $table->string('name')->unique();
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('description')->nullable();
                $table->string('image')->nullable();
                $table->string('icon')->nullable();
                $table->string('url');
                $table->boolean('active')->default(1);
                $table->string('target')->default('_self');
                /*
                    _self
                    _blank
                */
                $table->timestamps();
                $table->primary('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_links');
        Schema::dropIfExists('menu_items');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('article_multimedias');
        Schema::dropIfExists('content_articles');
        Schema::dropIfExists('multimedia_contents');
        Schema::dropIfExists('content_categories');
        Schema::dropIfExists('cuts');
    }
}
