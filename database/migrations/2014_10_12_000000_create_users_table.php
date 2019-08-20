<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $output = new ConsoleOutput();
        $bar = new ProgressBar($output, 1);
        $bar->start();

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

        Schema::dropIfExists('users');
        $bar->advance();

        $bar->finish();
        print("\n");
    }
}
