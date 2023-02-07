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
        Schema::create('booking__tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels');
            $table->foreignId('place_id')->nullable()->constrained('places');
            $table->foreignId('resturant_id')->nullable()->constrained('resturants');
            $table->foreignId('company_id')->nullable()->constrained('transport_company');
            $table->foreignId('trans_comp_type_id')->nullable()->constrained('transport_type');
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
        Schema::dropIfExists('booking__tours');
    }
};
