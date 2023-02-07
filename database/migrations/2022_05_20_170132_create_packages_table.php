<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('added_by');
            $table->string('name');
            $table->integer('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration');
            $table->integer('no_people');
            $table->integer('rating')->default(0);
            $table->integer('views')->default(0);
            $table->string('package_image');
            $table->text('description');
            $table->string('company_name');
            $table->string('transport_type');
            $table->string('hotel_name');
            $table->json('places')->nullable();
            $table->string('approved_status')->default('NO');
            $table->foreignId('country_id')->constrained('countries');
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
        Schema::dropIfExists('packages');
    }
};
