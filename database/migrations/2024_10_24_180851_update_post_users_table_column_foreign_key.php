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
        Schema::table('post_users', static function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->comment('جدول واسط پست ها و کاربران ثبت کننده آنها');
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
