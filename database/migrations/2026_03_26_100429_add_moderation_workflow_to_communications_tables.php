<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // Agregar campos de moderación a news
        Schema::table('news', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending_review', 'published', 'archived'])
                ->default('draft')
                ->after('content');
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('status');
            $table->timestamp('approved_at')
                ->nullable()
                ->after('approved_by');
            $table->text('moderation_notes')
                ->nullable()
                ->after('approved_at');
            $table->jsonb('version_history')
                ->nullable()
                ->after('moderation_notes');

            $table->index(['status', 'created_at']);
            $table->index('approved_by');
        });

        // Agregar campos de moderación a polls
        Schema::table('polls', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending_review', 'published', 'archived'])
                ->default('draft')
                ->after('question');
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('status');
            $table->timestamp('approved_at')
                ->nullable()
                ->after('approved_by');
            $table->text('moderation_notes')
                ->nullable()
                ->after('approved_at');
            $table->jsonb('version_history')
                ->nullable()
                ->after('moderation_notes');

            $table->index(['status', 'created_at']);
            $table->index('approved_by');
        });

        // Agregar campos de moderación a shoutouts
        Schema::table('shoutouts', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending_review', 'published', 'archived'])
                ->default('draft')
                ->after('content');
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->after('status');
            $table->timestamp('approved_at')
                ->nullable()
                ->after('approved_by');
            $table->text('moderation_notes')
                ->nullable()
                ->after('approved_at');
            $table->jsonb('version_history')
                ->nullable()
                ->after('moderation_notes');

            $table->index(['status', 'created_at']);
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['approved_by']);
            $table->dropColumn([
                'status',
                'approved_by',
                'approved_at',
                'moderation_notes',
                'version_history'
            ]);
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['approved_by']);
            $table->dropColumn([
                'status',
                'approved_by',
                'approved_at',
                'moderation_notes',
                'version_history'
            ]);
        });

        Schema::table('shoutouts', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
            $table->dropIndex(['approved_by']);
            $table->dropColumn([
                'status',
                'approved_by',
                'approved_at',
                'moderation_notes',
                'version_history'
            ]);
        });
    }
};
