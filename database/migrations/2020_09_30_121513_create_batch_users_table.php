<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->index()->constrained();
            $table->foreignId('parent_batch_id')->nullable()->index()->constrained('batches');
            $table->foreignId('user_id')->index()->constrained();
            $table->boolean('accept_agreement')->nullable();
            $table->string('certificate', 64)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', ['active', 'inactive', 'completed'])->default('inactive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_users');
    }
}
