<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            // 基本カラム
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('no action');
            $table->string('place_id')->unique()->comment('Google Places ID');
            $table->text('memo')->nullable()->comment('ユーザーメモ');
            $table->timestamp('last_checked_at')->nullable()->comment('Places API最終確認日時');
            $table->enum('status', ['active', 'closed', 'unknown'])->default('active')->comment('店舗状態');
            $table->timestamps();

            // インデックス
            $table->index('user_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stores');
    }
};