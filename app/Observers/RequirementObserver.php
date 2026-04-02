<?php

namespace App\Observers;

use App\Models\Requirement;

class RequirementObserver
{
    public function creating(Requirement $requirement)
    {
        if (!$requirement->order) {
            $requirement->order = Requirement::where('course_id', $requirement->course_id)->max('order') + 1;
        }
    }
}
