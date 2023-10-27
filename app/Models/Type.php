<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'color',
    ];

    // inserisco la relazione tra i modelli (da fare anche nel secondo modello)
    public function projects()
    {
        // hasMany è per la relazione FORTE
        return $this->hasMany(Project::class);
    }
}