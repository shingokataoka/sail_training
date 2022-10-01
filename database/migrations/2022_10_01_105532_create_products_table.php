<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('information');
            $table->unsignedInteger('price');
            $table->integer('sort_order')->nullable();
            $table->boolean('is_selling');
            
            $table->foreignId('shop_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('secondary_category_id')->constrained()
                ->onUpdate('cascade');

            $table->foreignId('image1_id')->nullable()->constrained('images')
                ->onUpdate('cascade');
            $table->foreignId('image2_id')->nullable()->constrained('images')
                ->onUpdate('cascade');
            $table->foreignId('image3_id')->nullable()->constrained('images')
                ->onUpdate('cascade');
            $table->foreignId('image4_id')->nullable()->constrained('images')
                ->onUpdate('cascade');


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
        Schema::dropIfExists('products');
    }
};
