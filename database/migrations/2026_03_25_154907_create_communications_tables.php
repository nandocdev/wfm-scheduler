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
        // Noticias
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->foreignId('author_id')->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Shoutouts (Reconocimientos rápidos)
        Schema::create('shoutouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->text('message');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Encuestas (Polls)
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->jsonb('options'); // [{label, value}]
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // Respuestas de Encuestas
        Schema::create('poll_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained('polls')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('answer');
            $table->timestamps();
            $table->unique(['poll_id', 'user_id']); // Solo un voto por usuario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_responses');
        Schema::dropIfExists('polls');
        Schema::dropIfExists('shoutouts');
        Schema::dropIfExists('news');
    }
};
