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
        Schema::create('identity_providers', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('uid'); // プロバイダーでのユーザーID(一意の値）
            $table->string('provider'); // githubなどのプロバイダー名
            $table->primary(['uid', 'provider']); // 複合キーでインデックスを追加
            $table->unique(['user_id', 'provider']); // ユニーク制約
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identity_providers');
    }
};
