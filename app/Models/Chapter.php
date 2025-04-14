<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'story_id', 
        'chapter_number', 
        'content', 
        'stress_level', 
        'stress_impact', 
        'is_recovery_point', 
        'stress_advice'
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