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
        Schema::create('troupes', function (Blueprint $table) {
            $table->id();
            // usersテーブルとの紐づけ（1対1なのでunique()をつける）
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('name');//団体名
            $table->string('representative_name', 100);//代表者名
            $table->string('prefecture', 20);//活動拠点（都道府県）
            $table->text('description')->nullable();//劇団紹介（空でもOKなようにnullable）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('troupes');
    }
};
