<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawab extends Model
{
    protected $table = 'jawab';
    protected $fillable = ['user_id', 'tanya_id', 'konten', 'is_accepted'];

    public function tanya()
    {
        return $this->belongsTo(Tanya::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function resources()
    {
        return $this->hasMany(Resource::class, 'jawab_id');
    }
}
