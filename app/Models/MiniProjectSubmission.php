<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniProjectSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'mini_project_id',
        'user_id',
        'catatan',
        'status',
        'feedback',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function miniProject()
    {
        return $this->belongsTo(MiniProject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }
}
