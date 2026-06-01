<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Alter Users Table for Roles
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'parent', 'student'])->default('student');
            $table->foreignId('parent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('total_points')->default(0);
        });

        // 2. Experiments Table
        Schema::create('experiments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category'); // Kimia, Fisika, Biologi
            $table->enum('difficulty', ['Mudah', 'Sedang', 'Sulit']);
            $table->integer('duration_minutes');
            $table->integer('points_reward')->default(10);
            $table->json('simulation_data'); // Stores steps, required tools, expected results
            $table->timestamps();
        });

        // 3. Educational Materials Table
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experiment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->longText('content');
            $table->timestamps();
        });

        // 4. User Progress (Pivot/Tracking)
        Schema::create('experiment_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('experiment_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['started', 'quiz_pending', 'completed'])->default('started');
            $table->integer('score')->nullable();
            $table->integer('current_step')->default(1);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiment_progress');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('experiments');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'parent_id', 'total_points']);
        });
    }
};
