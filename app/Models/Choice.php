<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Choice
 *
 * Modèle représentant un choix effectué par l'utilisateur dans un chapitre.
 * Chaque choix appartient à un chapitre et peut mener à un chapitre suivant.
 *
 * @property int $chapter_id
 * @property string $text
 * @property int|null $next_chapter_id
 *
 * @package App\Models
 */
class Choice extends Model
{
    /**
     * Attributs modifiables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = ['chapter_id', 'text', 'next_chapter_id'];

    /**
     * Relation : ce choix appartient à un chapitre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * Relation : ce choix mène potentiellement à un autre chapitre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nextChapter()
    {
        return $this->belongsTo(Chapter::class, 'next_chapter_id');
    }
}
