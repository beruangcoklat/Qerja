<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('city_id')->unsigned();
            $table->integer('company_category_id')->unsigned();

            $table->string('location')->default('company location');
            $table->string('email')->default('company@company.com');
            $table->string('phone')->default('0123456789');
            $table->string('description')->default('description');
            $table->string('image')->default('pepsi.png');
            $table->string('website')->default('www.company.com');

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('company_category_id')->references('id')->on('company_categories');
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
        Schema::dropIfExists('companies');
    }
}
