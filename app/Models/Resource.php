<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';
    protected $fillable = ['resource_link', 'tutorial_id', 'tanya_id', 'jawab_id'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}
