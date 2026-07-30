<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('role_preset_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_preset_id')->constrained('role_presets')->cascadeOnDelete();
            $table->foreignId('system_id')->constrained()->cascadeOnDelete();
            $table->string('permission');
            $table->timestamps();

            $table->unique(['role_preset_id', 'system_id', 'permission'], 'role_preset_sys_perm_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_preset_permissions');
        Schema::dropIfExists('role_presets');
    }
};
