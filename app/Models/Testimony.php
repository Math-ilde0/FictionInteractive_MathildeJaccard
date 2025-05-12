<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Testimony
 *
 * Modèle représentant un témoignage d'utilisateur.
 * Chaque témoignage appartient à un utilisateur.
 *
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property string|null $status
 *
 * @package App\Models
 */
class Testimony extends Model
{
    use HasFactory;

    /**
     * Désactive les timestamps (created_at / updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributs modifiables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * Relation : ce témoignage appartient à un utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
