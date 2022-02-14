<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPriceColumnInProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('color_id')->after('size_id');
            $table->float('mrp',10,2)->after('color_id');
            $table->integer('discount')->after('mrp');
            $table->float('actual_price',10,2)->after('discount')->comment('After deduction the discount the final price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('mrp');
            $table->dropColumn('discount');
            $table->dropColumn('actual_price');
        });
    }
}
