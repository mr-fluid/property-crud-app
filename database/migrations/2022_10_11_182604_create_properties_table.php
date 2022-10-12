<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->string('uuid')->unique();
            $table->string('county');
            $table->string('country');
            $table->string('town');
            $table->longText('description');
            $table->string('postcode')->nullable(true);
            $table->string('full_details_url')->nullable(true);
            $table->string('address');
            $table->string('image_full');
            $table->string('image_thumbnail');
            $table->string('latitude')->nullable(true);
            $table->string('longitude')->nullable(true);
            $table->string('num_bedrooms');
            $table->string('num_bathrooms');
            $table->string('price');
            $table->string('type');
            $table->string('property_type');
            $table->string('data_source');
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
        Schema::dropIfExists('properties');
    }
}
