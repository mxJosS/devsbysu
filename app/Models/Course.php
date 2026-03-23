<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\CourseStatus;
class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'image_path',
        'video_path',
        'welcome_message',
        'goobye_message',
        'observation',
        'user_id',
        'level_id',
        'category_id',
        'price_id',
    ];

    protected $casts =[
        'status' => CourseStatus::class,
    
    ];
    
    public function teacher(){
        return $this->belongsTo(User::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function price(){
        return $this->belongsTo(Price::class);
    }

}
