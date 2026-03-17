<?php

namespace App\Traits;

use App\Models\Resource;
use Illuminate\Support\Facades\Auth;

trait HandlesMediaFromHtml
{
    protected function attachMediaFromHtml(string $html, $model): void
    {
        preg_match_all('/src="([^"]+)"/', $html, $matches);

        foreach ($matches[1] as $url) {
            if (str_contains($url, '/storage/')) {
                $path = str_replace(asset('/storage/') . '/', '', $url);
                $resource = Resource::where('path', 'like', "%{$path}%")->first();
                if ($resource) {
                    $resource->update([
                        'resourceable_id'   => $model->id,
                        'resourceable_type' => get_class($model),
                    ]);
                }
            } elseif (str_starts_with($url, 'http')) {
                Resource::firstOrCreate(
                    ['path' => $url, 'user_id' => Auth::id()],
                    [
                        'type'             => 'video_link',
                        'resourceable_id'  => $model->id,
                        'resourceable_type' => get_class($model),
                    ]
                );
            }
        }
    }
}
