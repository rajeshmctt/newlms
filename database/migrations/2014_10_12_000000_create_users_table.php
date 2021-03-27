<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 32);
            $table->string('last_name', 32)->nullable();
            $table->string('email', 64)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->string('photo', 64)->nullable();
            $table->text('description')->nullable();
            $table->string('current_organisation_name')->nullable();
            $table->string('current_organisation_website')->nullable();
            $table->string('facebook_profile_url')->nullable();
            $table->string('linkedin_profile_url')->nullable();
            $table->string('instagram_profile_url')->nullable();
            $table->string('twitter_profile_url')->nullable();
            $table->timestamp('last_logged_in_at')->nullable();
            $table->timestamp('logged_in_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
