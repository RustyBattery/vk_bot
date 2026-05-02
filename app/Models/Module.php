<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'description'])]
class Module extends Model
{
    public function questions(): HasMany
    {
        return $this->hasMany(ModuleQuestion::class);
    }
}
