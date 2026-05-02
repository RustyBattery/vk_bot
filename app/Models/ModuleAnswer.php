<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['question_id', 'value', 'is_correct'])]
class ModuleAnswer extends Model
{
    public function question(): BelongsTo
    {
        return $this->belongsTo(ModuleQuestion::class, 'question_id');
    }
}
