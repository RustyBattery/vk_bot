<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'practice_id', 'stress_before', 'stress_after', 'comment'])]
class UserPractice extends Model
{
    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }
}
