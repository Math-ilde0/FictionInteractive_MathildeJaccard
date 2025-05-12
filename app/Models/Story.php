<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Story
 *
 * Modèle représentant une histoire interactive.
 * Chaque histoire peut contenir plusieurs chapitres.
 *
 * @property string $title
 * @property string $summary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @package App\Models
 */
class Story extends Model
{
    /**
     * Attributs modifiables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'summary'];

    /**
     * Conversion automatique des champs datetime.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation : une histoire contient plusieurs chapitres.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
