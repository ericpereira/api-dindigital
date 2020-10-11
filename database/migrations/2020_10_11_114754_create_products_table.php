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
            $table->string('id');
            $table->primary('id');
            $table->string('name');
            $table->float('price');
            $table->float('weight');
            $table->timestamps();

            $table->softDeletes();
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
			$table->dropSoftDeletes();
		});
		
        Schema::dropIfExists('products');
        
    }
}
