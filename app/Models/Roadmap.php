<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    protected $table = 'roadmap';

    protected $fillable = ['judul', 'deskripsi', 'sort_order'];

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class, 'roadmap_id')->orderBy('sort_order');
    }
}
