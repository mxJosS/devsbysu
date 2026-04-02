<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\RequirementObserver;

#[ObservedBy([RequirementObserver::class])]
class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
