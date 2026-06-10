<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Document;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'title',
        'description',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
