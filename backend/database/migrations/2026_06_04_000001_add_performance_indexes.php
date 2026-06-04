<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * ✅ PERFORMANCE FIX: Add missing database indexes
     * 
     * Improves query speed for:
     * - Login queries (username)
     * - Member ID lookups (member_id)
     * - Date filtering (joined_at)
     * - User searches
     * 
     * Expected improvement: 10-100x faster on large datasets
     */
    public function up(): void
    {
        // Only add indexes if table exists
        if (!Schema::hasTable('members')) {
            return;
        }

        // Check if indexes already exist before creating
        $indexesToCheck = [
            'idx_members_username' => ['username'],
            'idx_members_member_id' => ['member_id'],
            'idx_members_joined_at' => ['joined_at'],
        ];

        foreach ($indexesToCheck as $indexName => $columns) {
            if (!$this->indexExists('members', $columns)) {
                Schema::table('members', function (Blueprint $table) use ($columns) {
                    $table->index($columns);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropIndexIfExists(['username']);
                $table->dropIndexIfExists(['member_id']);
                $table->dropIndexIfExists(['joined_at']);
            });
        }
    }

    /**
     * Helper: Check if index exists
     */
    private function indexExists($table, $columns): bool
    {
        $indexes = DB::select(
            "SELECT INDEX_NAME FROM INFORMATION_SCHEMA.STATISTICS 
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? 
             AND COLUMN_NAME IN (" . implode(',', array_fill(0, count($columns), '?')) . ")",
            array_merge([$table], $columns)
        );
        return count($indexes) > 0;
    }
};
