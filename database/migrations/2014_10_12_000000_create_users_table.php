<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TABLE users
        if(!Schema::hasTable('users')){
            Schema::create('users', function(Blueprint $table){
                $table->uuid('id');
                $table->string('name',128)->nullable();
                $table->string('lastname', 128)->nullable();
                $table->string('email', 128)->unique();
                $table->string('password', 255);
                $table->string('temporary_password', 255)->nullable()->default(null);
                $table->string('avatar',128)->nullable();
                $table->char('type', 1);
                /*
                    S -> Superadministrator
                    A -> Administrator
                    B -> BackOffice
                    R -> Reporter
                    C -> Commerce
                    U -> Standard User
                */
                $table->boolean('status')->default(0);
                $table->rememberToken()->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->primary('id');
            });
        }

        // TABLE param_users
        if(!Schema::hasTable('param_users')){
            Schema::create('param_users', function (Blueprint $table) {
                $table->uuid('id');
                $table->string('context', 128);
                $table->string('code', 128);
                $table->string('description', 128);
                $table->uuid('user_id');
                $table->timestamps();
                $table->primary('id');
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('param_users');
        Schema::dropIfExists('users');
    }
}
