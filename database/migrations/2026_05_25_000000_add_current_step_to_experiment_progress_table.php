<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experiment_progress', function (Blueprint $table) {
            if (!Schema::hasColumn('experiment_progress', 'current_step')) {
                $table->integer('current_step')->default(1)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('experiment_progress', function (Blueprint $table) {
            if (Schema::hasColumn('experiment_progress', 'current_step')) {
                $table->dropColumn('current_step');
            }
        });
    }
};
