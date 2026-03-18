<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseKomentar extends Model
{
    use HasFactory;

    protected $table = 'showcase_komentars';
    protected $fillable = ['user_id', 'showcase_id', 'komentar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
}
