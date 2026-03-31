<?php

namespace App\Modules\SchedulingModule\Policies;

use App\Modules\CoreModule\Models\User;

class WeeklyScheduleAssignmentPolicy {
    public function create(User $user): bool {
        return $user->hasPermissionTo('schedules.assign') || $user->hasPermissionTo('schedules.manage');
    }
}
