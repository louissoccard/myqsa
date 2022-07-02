<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQsaRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qsa_records', function (Blueprint $table) {
            $table->id();
            $table->string('presentation_key');
            $table->foreignId('user_id')->constrained();
            $table->date('date_of_birth')->nullable();
            $table->date('explorers_start')->nullable();
            $table->date('explorers_end')->nullable();
            $table->date('network_start')->nullable();
            $table->date('network_end')->nullable();
            $table->string('dofe_organisation')->nullable();
            $table->string('dofe_number')->nullable();
            $table->date('dofe_completion')->nullable();
            $table->enum('dofe_volunteering', ['Not Started', 'In Progress', 'Complete'])->default('Not Started');
            $table->enum('dofe_physical', ['Not Started', 'In Progress', 'Complete'])->default('Not Started');
            $table->enum('dofe_skills', ['Not Started', 'In Progress', 'Complete'])->default('Not Started');
            $table->enum('dofe_expedition', ['Not Started', 'In Progress', 'Complete'])->default('Not Started');
            $table->enum('dofe_residential', ['Not Started', 'In Progress', 'Complete'])->default('Not Started');
            $table->string('presentation_name')->nullable();
            $table->string('presentation_email')->nullable();
            $table->date('presentation_date')->nullable();
            $table->text('presentation_statement')->nullable();
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
        Schema::dropIfExists('qsa_records');
    }
}
