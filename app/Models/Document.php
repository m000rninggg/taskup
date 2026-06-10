<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'document';

    protected $fillable = [
        'project_id',
        'title',
        'content',
        'updated_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}