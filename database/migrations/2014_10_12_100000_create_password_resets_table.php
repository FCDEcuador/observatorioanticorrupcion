<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class CreatePasswordResetsTable extends Migration
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

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
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
        $bar = new ProgressBar($output, 1);
        $bar->start();

        Schema::dropIfExists('password_resets');
        $bar->advance();

        $bar->finish();
        print("\n");
    }
}
