<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySubCategoryIdCoumnInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropColumn('sub_category_id');
        // });
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('range_id')->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
           $table->dropColumn('range_id');
        });
    }
}
