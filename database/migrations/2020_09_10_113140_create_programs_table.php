<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['program', 'elective'])->default('program');
            $table->string('name', 255);
            $table->string('code', 32)->nullable()->unique();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('image', 64)->nullable();
            $table->text('prerequisites')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->unsignedTinyInteger('zero_cost_electives')->nullable();
            $table->text('who_is_it_for')->nullable();
            $table->text('what_you_will_gain')->nullable();
            $table->enum('payment_mode', ['offline', 'online'])->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->unsignedTinyInteger('mentor_coach_meetings')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programs');
    }
}
