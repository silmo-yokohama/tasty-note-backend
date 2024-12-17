<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up()
  {
    Schema::create('photos', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('no action');
      $table->foreignId('store_id')->constrained()->onDelete('no action');
      $table->string('path');
      $table->string('title')->nullable();
      $table->text('description')->nullable();
      $table->timestamps();

      // インデックス
      $table->index('user_id');
      $table->index('store_id');
    });
  }

  public function down()
  {
    Schema::dropIfExists('photos');
  }
};
