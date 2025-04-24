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
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();

            $table->foreign('post_status_id')->references('id')->on('post_status')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('post_status_id')->comment('وضعیت پست');
            $table->string('title', 200)->comment('عنوان');
            $table->text('content')->nullable()->comment('محتوای پست');

            $table->timestamps();
            $table->softDeletes();

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
