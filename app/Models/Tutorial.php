<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $table = 'tutorial';

    protected $fillable = ['roadmap_id', 'judul', 'deskripsi', 'sort_order', 'konten'];

    public function roadmap()
    {
        return $this->belongsTo(Roadmap::class, 'roadmap_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'tutorial_id');
    }

    public function tanya()
    {
        return $this->hasMany(Tanya::class, 'tutorial_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'tutorial_id');
    }
}
