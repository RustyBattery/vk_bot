<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['user_id', 'module_id', 'status', 'scores', 'total_scores'])]
class ModuleAttempts extends Model
{
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(ModuleAnswer::class, 'attempt_answers', 'attempt_id', 'answer_id');
    }
}
