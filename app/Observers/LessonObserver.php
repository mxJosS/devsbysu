<?php

namespace App\Observers;
use App\Models\Lesson;


class LessonObserver
{
    public function creating(Lesson $lesson)
    {
        $lesson->order = Lesson::where('section_id',$lesson->section_id)->max('order') + 1;
    }
}
