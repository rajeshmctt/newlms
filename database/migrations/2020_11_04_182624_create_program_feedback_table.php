<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->foreignId('program_id')->index()->constrained();
            $table->text('feedback')->nullable();
            $table->enum('emoticon', ['like', 'insightful', 'curious', 'favourite'])->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_feedback');
    }
}
