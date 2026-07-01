<?php

namespace App\Models;

use Database\Factories\StrategicObjectiveFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['public_entity_id', 'code', 'name', 'description', 'pnd_alignment', 'ods_alignment', 'start_year', 'end_year', 'status'])]
class StrategicObjective extends Model
{
    /** @use HasFactory<StrategicObjectiveFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_INACTIVE = 'inactive';

    protected function casts(): array
    {
        return [
            'start_year' => 'integer',
            'end_year' => 'integer',
        ];
    }

    public function publicEntity(): BelongsTo
    {
        return $this->belongsTo(PublicEntity::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
