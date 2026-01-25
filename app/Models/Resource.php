<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = ['submodul_id', 'tanya_id', 'jawab_id', 'resource'];

    public function submodul()
    {
        return $this->belongsTo(Submodul::class);
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
