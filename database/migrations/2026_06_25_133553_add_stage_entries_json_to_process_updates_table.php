<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('process_updates', function (Blueprint $table) {
            $table->json('stage1_entries')->nullable()->after('stage1_date');
            $table->json('stage2_entries')->nullable()->after('stage2_date');
            $table->json('stage3_entries')->nullable()->after('stage3_date');
            $table->json('stage4_entries')->nullable()->after('stage4_date');
            $table->json('stage5_entries')->nullable()->after('stage5_date');
        });
    }

    public function down(): void
    {
        Schema::table('process_updates', function (Blueprint $table) {
            $table->dropColumn([
                'stage1_entries',
                'stage2_entries',
                'stage3_entries',
                'stage4_entries',
                'stage5_entries',
            ]);
        });
    }
};
