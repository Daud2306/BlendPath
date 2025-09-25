<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    // Pastikan memakai nama tabel yang benar
    protected $table = 'resources';

    // Gunakan nama kolom yang sesuai migration: resource_link
    protected $fillable = [
        'tutorial_id',
        'tanya_id',
        'jawab_id',
        'resource_link',
    ];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}