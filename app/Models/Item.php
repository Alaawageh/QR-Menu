<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Builder;

class Item extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $with = ['image'];
    
    public function image():MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function categories():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function scopeAvailable(Builder $builder) {
        return $builder->where('available',true);
    }
}
