<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorCoachSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_coach_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->foreignId('batch_id')->index()->constrained();
            $table->foreignId('faculty_id')->index()->constrained();
            $table->smallInteger('session_no')->nullable();
            $table->date('date')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['pending', 'active'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_coach_sessions');
    }
}
