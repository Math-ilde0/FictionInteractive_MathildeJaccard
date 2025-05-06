<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;
    public $timestamps = false; // This disables created_at and updated_at
    protected $fillable = [
        'user_id',
        'title',
        'content',
        
    ];

    /**
     * Get the user that owns the testimony.
     */
    public function user()
{
    return $this->belongsTo(User::class);
}

}