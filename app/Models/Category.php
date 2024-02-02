<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['image','items'];
    
    public function branches():BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
    public function image():MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function items():HasMany
    {
        return $this->hasMany(Item::class);
    }
    public function scopeAvailable(Builder $builder) {
        return $builder->where('available',true);
    }
}
