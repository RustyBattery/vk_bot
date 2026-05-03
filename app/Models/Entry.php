<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'module_id', 'text'])]
class Entry extends Model
{
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
