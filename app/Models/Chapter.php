<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'story_id', 
        'chapter_number', 
        'content', 
        'stress_impact', 
        'sleep_impact',
        'grades_impact',
        'stress_advice',
        'sleep_advice',
        'grades_advice'
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
    
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}