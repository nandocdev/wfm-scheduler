<?php

namespace App\Modules\SchedulingModule\Policies;

use App\Modules\CoreModule\Models\User;

class WeeklyScheduleAssignmentPolicy {
    public function create(User $user): bool {
        // Avoid throwing PermissionDoesNotExist when a permission record is missing.
        // Use getPermissionNames() which safely returns the user's assigned permission names.
        $names = $user->getPermissionNames();

        return $names->contains('schedules.assign') || $names->contains('schedules.manage');
    }
}
