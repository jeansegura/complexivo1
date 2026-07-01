<?php

namespace App\Models;

use Database\Factories\PlanActivityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['institutional_plan_id', 'name', 'description', 'responsible_unit', 'budget', 'start_date', 'end_date', 'status'])]
class PlanActivity extends Model
{
    /** @use HasFactory<PlanActivityFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_INACTIVE = 'inactive';

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function institutionalPlan(): BelongsTo
    {
        return $this->belongsTo(InstitutionalPlan::class);
    }
}
