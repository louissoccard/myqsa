<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcvActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icv_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qsa_record_id');
            $table->enum('category', ['International', 'Community', 'Values']);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('description');
            $table->boolean('part_of_csa');
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
        Schema::dropIfExists('icv_activities');
    }
}
