<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['category', 'meta', 'title', 'slug', 'excerpt', 'date', 'image_src', 'image_alt', 'content', 'published', 'sort_order'])]
class Article extends Model
{
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'content' => 'array',
            'published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected function src(): Attribute
    {
        return Attribute::get(fn () => $this->image_src);
    }

    protected function alt(): Attribute
    {
        return Attribute::get(fn () => $this->image_alt);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
}
