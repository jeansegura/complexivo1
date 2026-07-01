<?php

use App\Models\PublicEntity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('public_entities')->nullOnDelete();
            $table->string('name');
            $table->string('ruc', 13)->unique();
            $table->string('code')->nullable()->unique();
            $table->string('sector');
            $table->string('type');
            $table->string('status')->default(PublicEntity::STATUS_ACTIVE);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_entities');
    }
};
