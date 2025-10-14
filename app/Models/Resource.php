<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = ['tutorial_id', 'tanya_id', 'jawab_id', 'resource'];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }

    public function isYouTube()
    {
        return str_contains($this->resource, 'youtube.com/embed');
    }

    public function isLink()
    {
        return str_starts_with($this->resource, 'http');
    }

    public function getFileName()
    {
        return $this->isLink() ? 'External Link' : basename($this->resource);
    }
}
