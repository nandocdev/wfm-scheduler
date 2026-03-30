<?php

namespace App\Modules\SchedulingModule\Policies;

use App\Modules\CoreModule\Models\User;
use App\Modules\SchedulingModule\Models\BreakTemplate;

class BreakTemplatePolicy {
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo('break_templates.viewAny');
    }

    public function view(User $user, BreakTemplate $template): bool {
        return $user->hasPermissionTo('break_templates.viewAny');
    }

    public function create(User $user): bool {
        return $user->hasPermissionTo('break_templates.create');
    }

    public function update(User $user, BreakTemplate $template): bool {
        return $user->hasPermissionTo('break_templates.update');
    }

    public function delete(User $user, BreakTemplate $template): bool {
        return false;
    }
}
