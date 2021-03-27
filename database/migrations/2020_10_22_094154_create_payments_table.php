<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained();
            $table->string('payment_uid', 32)->nullable()->unique();
            $table->enum('payment_mode', ['offline', 'online'])->nullable();
            $table->enum('for', ['program', 'elective'])->nullable();
            $table->foreignId('program_id')->nullable()->index()->constrained();
            $table->foreignId('batch_id')->nullable()->index()->constrained();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->json('pg_response')->nullable();
            $table->enum('pg_payment_status', ['success', 'failed'])->nullable();
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
        Schema::dropIfExists('payments');
    }
}
