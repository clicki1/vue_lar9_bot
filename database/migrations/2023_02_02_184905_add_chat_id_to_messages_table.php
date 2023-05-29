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
        Schema::table('messages', function (Blueprint $table) {
            // 1. Create new column
            $table->integer('chat_id')->after('id')->nullable();

            $table->foreign('chat_id', 'message_chat_fk')->on('chats')->references('chat_id');
            $table->index('chat_id', 'message_chat_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // 1. Create new column
           $table->dropForeign('message_chat_fk');
           $table->dropIndex('message_chat_idx');
            $table->dropColumn('chat_id');
        });
    }
};
