<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_users', static function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('شناسه کاربر');
            $table->unsignedBigInteger('post_id')->comment('شناسه پست');
            $table->comment('جدول واسط پست ها و کاربرانی ثبت کرده آنها');

            // set foreign key
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // set unique columns
            $table->unique(['user_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_users');
    }
};
