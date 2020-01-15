<?php

namespace App\Models\Traits;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

trait Imageable {

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function storeImage()
    {
        $file = request()->file('image');
        $url = Storage::disk('public')->put('images', $file);

        $this->image()->create([
            'url' => $url
        ]);
    }

    public function imageUpdate()
    {
        if (request()->file('image')) {
            Storage::delete($this->image["url"]);
            $this->image()->delete();
            $this->storeImage();
        }
        return;
    }
}
