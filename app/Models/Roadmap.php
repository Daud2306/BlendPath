<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    use HasFactory;
    protected $table = 'roadmaps';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'sort_order'];

    public function tutorial()
    {
        return $this->hasMany(Tutorial::class);
    }
}
