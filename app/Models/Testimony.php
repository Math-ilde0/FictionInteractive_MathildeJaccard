<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'status'
    ];

    /**
     * Get the user that owns the testimony.
     */
    public function user()
{
    return $this->belongsTo(User::class);
}

}