<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToContactsTable extends Migration
{
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
