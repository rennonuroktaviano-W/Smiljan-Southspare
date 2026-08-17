<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'description', 'status', 'event_date', 'sort_order'])]
class Event extends Model
{
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'sort_order' => 'integer',
        ];
    }
}
