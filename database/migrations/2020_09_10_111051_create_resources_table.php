<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->enum('visibility', ['private', 'public'])->nullable();
            $table->enum('format', ['document', 'video', 'audio', 'other'])->nullable();
            $table->enum('type', ['file', 'link'])->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('file_name', 255)->nullable();
            $table->string('file', 64)->nullable();
            $table->text('link')->nullable();
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
        Schema::dropIfExists('resources');
    }
}
