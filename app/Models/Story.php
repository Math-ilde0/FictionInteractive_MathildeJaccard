<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['title', 'summary'];
    
    // Make sure timestamps are properly handled
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}