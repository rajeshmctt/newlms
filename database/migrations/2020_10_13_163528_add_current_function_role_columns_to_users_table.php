<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrentFunctionRoleColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('current_function_id')->after('location_id')->nullable()->index()->constrained();
            $table->foreignId('current_role_id')->after('current_function_id')->nullable()->index()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['current_function_id']);
            $table->dropForeign(['current_role_id']);
            $table->dropIndex(['current_function_id']);
            $table->dropIndex(['current_role_id']);
            $table->dropColumn(['current_function_id', 'current_role_id']);
        });
    }
}
