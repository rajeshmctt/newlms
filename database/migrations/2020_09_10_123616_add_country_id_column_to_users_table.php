<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryIdColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('country_id')->after('id')->nullable()->index()->constrained();
            $table->foreignId('location_id')->after('country_id')->nullable()->index()->constrained();
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
            $table->dropForeign(['country_id']);
            $table->dropForeign(['location_id']);
            $table->dropIndex(['country_id']);
            $table->dropIndex(['location_id']);
            $table->dropColumn(['country_id', 'location_id']);
        });
    }
}
