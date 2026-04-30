<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['material_id', 'title', 'text'])]
class MaterialBlock extends Model
{
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
