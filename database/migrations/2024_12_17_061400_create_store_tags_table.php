<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('store_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('no action');
            $table->foreignId('tag_id')->constrained()->onDelete('no action');
            $table->timestamp('created_at');

            // ユニーク制約
            $table->unique(['store_id', 'tag_id']);

            // インデックス
            $table->index('store_id');
            $table->index('tag_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('store_tags');
    }
};