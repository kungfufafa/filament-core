<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('systems', function (Blueprint $table) {
            $table->string('oauth_client_id')->nullable()->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('systems', function (Blueprint $table) {
            $table->dropColumn('oauth_client_id');
        });
    }
};
