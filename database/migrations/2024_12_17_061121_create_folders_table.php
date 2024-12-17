<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            // 基本カラム
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('no action');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('share_url')->nullable()->unique();
            $table->timestamp('share_expired_at')->nullable();
            $table->timestamps();

            // インデックス
            $table->index('user_id');
            $table->index('share_url');
        });
    }

    public function down()
    {
        Schema::dropIfExists('folders');
    }
};