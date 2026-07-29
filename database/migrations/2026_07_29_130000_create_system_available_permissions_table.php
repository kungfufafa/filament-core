<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_available_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_id')->constrained()->cascadeOnDelete();
            $table->string('permission');
            $table->string('label')->nullable();
            $table->timestamps();

            $table->unique(['system_id', 'permission']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_available_permissions');
    }
};
