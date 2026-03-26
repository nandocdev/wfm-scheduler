<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Observers;

use App\Modules\CommunicationsModule\Models\Comment;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Comment.
 * Maneja efectos secundarios como caché y limpieza.
 */
class CommentObserver {
    public function created(Comment $comment): void {
        Cache::tags(['comments', "news:{$comment->news_id}"])->flush();
    }

    public function updated(Comment $comment): void {
        Cache::tags(['comments', "news:{$comment->news_id}"])->flush();
    }

    public function deleted(Comment $comment): void {
        Cache::tags(['comments', "news:{$comment->news_id}"])->flush();
    }
}
