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
        Schema::table('posts', static function (Blueprint $table) {
            $table->foreignId('post_status_id')->comment('وضعیت پست')->change();
            $table->string('title', 200)->comment('عنوان')->change();
            $table->text('content')->comment('محتوای پست')->change();

            $table->comment('پست ها');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
