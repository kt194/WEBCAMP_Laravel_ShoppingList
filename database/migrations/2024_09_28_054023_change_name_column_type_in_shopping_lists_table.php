<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNameColumnTypeInShoppingListsTable extends Migration
{
    public function up()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->string('name', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('shopping_lists', function (Blueprint $table) {
            $table->string('name', 128)->change();
        });
    }
}
