<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatHappendFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('what_happened', function ($table) {
            $table->string('year_end')->nullable()->after('day');
            $table->string('month_end')->nullable()->after('year_end');
            $table->string('day_end')->nullable()->after('month_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('what_happened', function ($table) {
            $table->dropColumn(['year_end']);
            $table->dropColumn(['month_end']);
            $table->dropColumn(['day_end']);
        });
    }
}
