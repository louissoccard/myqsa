<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNightsAwayEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nights_away_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qsa_record_id');
            $table->string('name');
            $table->date('start_date');
            $table->enum('type', ['Indoors', 'Camping']);
            $table->integer('number_of_nights');
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
        Schema::dropIfExists('nights_away_events');
    }
}
