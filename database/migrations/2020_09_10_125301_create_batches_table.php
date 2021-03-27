<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['self', 'sponsor'])->nullable();
            $table->foreignId('program_id')->index()->constrained();
            $table->foreignId('country_id')->nullable()->index()->constrained();
            $table->foreignId('location_id')->nullable()->index()->constrained();
            $table->foreignId('company_id')->nullable()->index()->constrained();
            $table->string('name', 64);
            $table->text('description')->nullable();
            $table->string('contact_person', 64)->nullable();
            $table->string('contact_email', 32)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('frequency', 64)->nullable();
            $table->string('session_information')->nullable();
            $table->unsignedTinyInteger('zero_cost_electives')->nullable();
            $table->unsignedTinyInteger('mentor_coach_meetings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['active', 'inactive', 'cancelled', 'completed'])->default('inactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batches');
    }
}
