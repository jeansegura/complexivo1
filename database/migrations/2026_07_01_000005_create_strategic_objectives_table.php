<?php

use App\Models\StrategicObjective;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('strategic_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_entity_id')->constrained()->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('pnd_alignment')->nullable();
            $table->string('ods_alignment')->nullable();
            $table->unsignedSmallInteger('start_year');
            $table->unsignedSmallInteger('end_year');
            $table->string('status')->default(StrategicObjective::STATUS_DRAFT);
            $table->timestamps();

            $table->unique(['public_entity_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('strategic_objectives');
    }
};
