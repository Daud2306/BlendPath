<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';
    protected $fillable = ['tutorial_id', 'tanya_id', 'jawab_id', 'resource_link'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
    public function tanya()
    {
        return $this->belongsTo(Tanya::class);
    }
    public function jawab()
    {
        return $this->belongsTo(Jawab::class);
    }
}
