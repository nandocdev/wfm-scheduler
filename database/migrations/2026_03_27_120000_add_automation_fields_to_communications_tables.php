<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('news', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('published_at');
            $table->timestamp('archive_at')->nullable()->after('scheduled_at');

            $table->index(['status', 'scheduled_at'], 'news_status_scheduled_at_index');
            $table->index(['status', 'archive_at'], 'news_status_archive_at_index');
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('expires_at');
            $table->timestamp('archive_at')->nullable()->after('scheduled_at');
            $table->timestamp('reminder_sent_at')->nullable()->after('archive_at');

            $table->index(['status', 'scheduled_at'], 'polls_status_scheduled_at_index');
            $table->index(['status', 'archive_at'], 'polls_status_archive_at_index');
            $table->index('reminder_sent_at', 'polls_reminder_sent_at_index');
        });

        Schema::table('shoutouts', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('created_at');
            $table->timestamp('archive_at')->nullable()->after('scheduled_at');

            $table->index(['status', 'scheduled_at'], 'shoutouts_status_scheduled_at_index');
            $table->index(['status', 'archive_at'], 'shoutouts_status_archive_at_index');
        });
    }

    public function down(): void {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex('news_status_scheduled_at_index');
            $table->dropIndex('news_status_archive_at_index');
            $table->dropColumn(['scheduled_at', 'archive_at']);
        });

        Schema::table('polls', function (Blueprint $table) {
            $table->dropIndex('polls_status_scheduled_at_index');
            $table->dropIndex('polls_status_archive_at_index');
            $table->dropIndex('polls_reminder_sent_at_index');
            $table->dropColumn(['scheduled_at', 'archive_at', 'reminder_sent_at']);
        });

        Schema::table('shoutouts', function (Blueprint $table) {
            $table->dropIndex('shoutouts_status_scheduled_at_index');
            $table->dropIndex('shoutouts_status_archive_at_index');
            $table->dropColumn(['scheduled_at', 'archive_at']);
        });
    }
};
