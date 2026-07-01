<?php

use App\Models\InstitutionalPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutional_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_entity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('strategic_objective_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('start_year');
            $table->unsignedSmallInteger('end_year');
            $table->string('status')->default(InstitutionalPlan::STATUS_DRAFT);
            $table->timestamps();

            $table->unique(['public_entity_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutional_plans');
    }
};
