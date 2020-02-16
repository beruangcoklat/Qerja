<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('positive');
            $table->string('negative');
            $table->integer('star');
            
            $table->integer('gaji_tunjangan');
            $table->integer('jenjang_karir');
            $table->integer('work_life_balance');
            $table->integer('nilai_budaya');
            $table->integer('manajemen_senior');

            $table->integer('position_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('lama_bekerja');
            $table->string('status_karyawan');
            $table->string('gaji');
            $table->string('periode');

            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('reviews');
    }
}
