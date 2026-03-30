<?php

namespace App\Modules\AuditModule\Policies;

use App\Modules\CoreModule\Models\User;
use App\Modules\AuditModule\Models\AuditLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuditLogPolicy {
    use HandlesAuthorization;

    public function viewAny(User $user): bool {
        return $user->hasRole('admin');
    }

    public function view(User $user, AuditLog $auditLog): bool {
        return $user->hasRole('admin');
    }

    public function export(User $user): bool {
        return $user->hasRole('admin');
    }
}
