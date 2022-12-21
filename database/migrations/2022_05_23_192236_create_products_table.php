<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id', true);
            $table->string('product_name', 255);
            $table->string('img', 255);
            $table->decimal('product_price', 7, 2)->nullable();
            $table->decimal('product_total_price', 7, 2)->nullable();
            $table->decimal('product_weight', 7, 3);
            $table->text('description');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict'); 
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                ->references('id')
                ->on('products_cat')
                ->onDelete('restrict')
                ->onUpdate('restrict'); 
            $table->string('slug');
            $table->smallInteger('product_quantity'); 
            $table->boolean('state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table){
            $table->dropForeign('products_user_id_foreign');
        });
        Schema::dropIfExists('products');
    }
}
