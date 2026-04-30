<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'text'])]
class Material extends Model
{
    public function blocks(): HasMany
    {
        return $this->hasMany(MaterialBlock::class);
    }
}
