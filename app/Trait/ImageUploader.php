<?php
namespace App\Trait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

Trait ImageUploader {
    public function uploadImage(UploadedFile $file , string $path , Model $model) {
        $url = $file->storePublicly($path,['disk'=>'public']);
        $model->image()->create([
            'url' => $url
        ]);
    }
    public function UpdateImage(UploadedFile $file , string $path , Model $model) {
        $image = $model->image?->url;
        if (isset($image)) {
            Storage::disk('public')->delete($model->image->url);
        }
        $url = $file->storePublicly($path,['disk'=>'public']);
        $model->image()->updateOrCreate(['id' => $model->image?->id],[
            'url' => $url
        ]);  
    }
    public function DeleteImage(Model $model) {
        $image = $model->image?->url;
        if ($image) {
            Storage::disk('public')->delete($model->image->url); 
        }
        $model->image()?->delete();
    }
}
