<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawab extends Model
{
    use HasFactory;

    protected $table = 'jawab';
    protected $fillable = ['user_id', 'tanya_id', 'konten'];
    protected $casts = ['is_accepted' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanya()
    {
        return $this->belongsTo(Tanya::class);
    }
}
