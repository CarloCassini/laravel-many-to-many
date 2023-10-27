<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Type;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'git_url',
        'description',
        'type_id',
    ];

    // inserisco la relazione tra i modelli (da fare anche nel secondo modello)
    public function type()
    {
        // belongsTo è un collegamento della relazione DEBOLE
        return $this->belongsTo(Type::class);
    }
}