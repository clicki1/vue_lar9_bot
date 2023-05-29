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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('path')->nullable();
            $table->timestamp('first_message_at')->nullable();
            $table->timestamp('latest_message_at')->nullable();
            $table->text('array_parsing')->nullable();
            $table->timestamp('uploads')->nullable();
            $table->integer('chat_id')->nullable();
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
        Schema::dropIfExists('files');
    }
};
