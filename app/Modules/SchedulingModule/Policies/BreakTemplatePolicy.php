<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Policies;

use App\Modules\CoreModule\Models\User;
use App\Modules\SchedulingModule\Models\BreakTemplate;

class BreakTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('break_templates.viewAny');
    }

    public function view(User $user, BreakTemplate $breakTemplate): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('break_templates.create')
            || $user->hasPermissionTo('schedules.manage');
    }

    public function update(User $user, BreakTemplate $breakTemplate): bool
    {
        return $user->hasPermissionTo('break_templates.update')
            || $user->hasPermissionTo('schedules.manage');
    }

    public function delete(User $user, BreakTemplate $breakTemplate): bool
    {
        return false;
    }
}
