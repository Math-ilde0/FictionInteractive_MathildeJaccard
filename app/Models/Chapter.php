<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Chapter
 *
 * Modèle représentant un chapitre d'une histoire interactive.
 * Chaque chapitre peut avoir plusieurs choix associés et appartient à une seule histoire.
 *
 * @property int $story_id
 * @property int $chapter_number
 * @property string $content
 * @property int|null $stress_impact
 * @property int|null $sleep_impact
 * @property int|null $grades_impact
 * @property string|null $stress_advice
 * @property string|null $sleep_advice
 * @property string|null $grades_advice
 *
 * @package App\Models
 */
class Chapter extends Model
{
    /**
     * Attributs modifiables en masse.
     *
     * @var array<int, string>
     */
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

    /**
     * Relation : ce chapitre appartient à une histoire.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
    
    /**
     * Relation : ce chapitre a plusieurs choix possibles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices()
    {
        return $this->hasMany(Choice::class);
    }
}
