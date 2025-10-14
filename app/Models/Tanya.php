<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanya extends Model
{
    use HasFactory;
    protected $table = 'tanyas';
    protected $fillable = ['user_id', 'tutorial_id', 'pertanyaan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }

    public function jawabs()
    {
        return $this->hasMany(Jawab::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'tanya_id');
    }

    protected static function booted()
    {
        static::deleting(function ($tanya) {
            $tanya->jawabs()->delete();
        });
    }
}
