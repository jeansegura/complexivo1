<?php

namespace App\Models;

use Database\Factories\InstitutionalPlanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['public_entity_id', 'strategic_objective_id', 'code', 'name', 'type', 'description', 'start_year', 'end_year', 'status'])]
class InstitutionalPlan extends Model
{
    /** @use HasFactory<InstitutionalPlanFactory> */
    use HasFactory;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_REVIEW = 'review';

    public const STATUS_APPROVED = 'approved';

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

    public function strategicObjective(): BelongsTo
    {
        return $this->belongsTo(StrategicObjective::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(PlanActivity::class);
    }
}
