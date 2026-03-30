<?php

namespace App\Modules\SchedulingModule\Policies;

use App\Modules\CoreModule\Models\User;
use App\Modules\SchedulingModule\Models\Schedule;

class SchedulePolicy {
    public function viewAny(User $user): bool {
        return $user->hasPermissionTo('schedules.viewAny');
    }

    public function view(User $user, Schedule $schedule): bool {
        return $user->hasPermissionTo('schedules.viewAny');
    }

    public function create(User $user): bool {
        return $user->hasPermissionTo('schedules.create');
    }

    public function update(User $user, Schedule $schedule): bool {
        return $user->hasPermissionTo('schedules.update');
    }

    public function delete(User $user, Schedule $schedule): bool {
        return false;
    }
}
