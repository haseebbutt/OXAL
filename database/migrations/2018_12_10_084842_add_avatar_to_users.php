<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('avatar_name')->nullable()->after('phone_number');
            $table->string('avatar_name_without_ext')->nullable()->after('avatar_name');
            $table->string('avatar_ext')->nullable()->after('avatar_name_without_ext');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('avatar_name');
            $table->dropColumn('avatar_name_without_ext');
            $table->dropColumn('avatar_ext');
        });
    }
}
