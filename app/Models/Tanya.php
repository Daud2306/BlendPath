<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tanya extends Model
{
    protected $table = 'tanya';
    protected $fillable = ['user_id', 'tutorial_id', 'konten'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jawab()
    {
        return $this->hasMany(Jawab::class, 'tanya_id');
    }
    public function resources()
    {
        return $this->hasMany(Resource::class, 'tanya_id');
    }
}
