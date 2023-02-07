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
        Schema::create('transport_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ticket_price');
            $table->date('start_date');
            $table->foreignId('company_id')->constrained('transport_company');
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
        Schema::dropIfExists('transport_type');
    }
};
