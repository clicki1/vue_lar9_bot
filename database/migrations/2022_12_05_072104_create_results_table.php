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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coast');
            $table->string('text')->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('message_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('category_id', 'result_category_idx');
            $table->foreign('category_id', 'result_category_fk')->on('categories')->references('id');

            $table->index('user_id', 'result_user_idx');
            $table->foreign('user_id', 'result_user_fk')->on('users')->references('id');

            $table->index('message_id', 'result_message_idx');
            $table->foreign('message_id', 'result_message_fk')->on('messages')->references('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
