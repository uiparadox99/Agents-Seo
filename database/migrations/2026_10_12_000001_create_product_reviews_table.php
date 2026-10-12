<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_reviews')) {
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->increments('id');
                $table->string('product_type', 50)->default('package'); // 'package' or 'tour'
                $table->integer('product_id')->unsigned();
                $table->integer('user_id')->unsigned()->nullable();
                $table->string('name', 100);
                $table->tinyInteger('rating')->unsigned(); // 1 to 5
                $table->text('comment');
                $table->boolean('approved')->default(false);
                $table->timestamps();

                $table->index(['product_type', 'product_id', 'approved'], 'idx_prod_reviews_lookup');
                $table->index('approved', 'idx_prod_reviews_approved');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}
