<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No-op migration: username is no longer required for email-based auth.
    }

    public function down(): void
    {
        // No-op rollback.
    }
};
