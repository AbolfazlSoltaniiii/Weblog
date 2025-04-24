<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_status', static function (Blueprint $table) {
            $table->id();

            $table->string('code', 100)->comment('کد');
            $table->string('title', 150)->comment('عنوان');

            $table->timestamps();
            $table->softDeletes();

            $table->comment('وضعیت پست');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_status');
    }
};
