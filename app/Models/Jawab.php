<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawab extends Model
{
    use HasFactory;

    protected $table = 'jawabs';
    protected $fillable = ['user_id', 'tanya_id', 'jawaban'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanya()
    {
        return $this->belongsTo(Tanya::class);
    }

    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }

    protected static function booted()
    {
        static::deleting(function ($jawab) {
            $jawab->resources()->delete();
        });
    }
}
