<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformanceIndexes extends Migration
{
    /**
     * Run the migrations.
     * Adds indexes needed for the admin/agents page to load fast.
     *
     * @return void
     */
    public function up()
    {
        // Index on visitors.agents_id for withCount('visitors')
        if (!$this->indexExists('visitors', 'idx_visitors_agents_id')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->index('agents_id', 'idx_visitors_agents_id');
            });
        }

        // Composite index on visitors (agents_id, created_at) for today_visitors filter
        if (!$this->indexExists('visitors', 'idx_visitors_agents_created')) {
            Schema::table('visitors', function (Blueprint $table) {
                $table->index(['agents_id', 'created_at'], 'idx_visitors_agents_created');
            });
        }

        // Index on foreign_jobs.agents_id for withCount('foreignJobs')
        if (!$this->indexExists('foreign_jobs', 'idx_foreign_jobs_agents_id')) {
            Schema::table('foreign_jobs', function (Blueprint $table) {
                $table->index('agents_id', 'idx_foreign_jobs_agents_id');
            });
        }

        // Composite index on agents for the common filter (is_foreign, active)
        if (!$this->indexExists('agents', 'idx_agents_filter')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->index(['is_foreign', 'active', 'deleted_at'], 'idx_agents_filter');
            });
        }

        // Index on agents.users_id used in JOIN with users table
        if (!$this->indexExists('agents', 'idx_agents_users_id')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->index('users_id', 'idx_agents_users_id');
            });
        }

        // Index on agents.cities_id for city filter
        if (!$this->indexExists('agents', 'idx_agents_cities_id')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->index('cities_id', 'idx_agents_cities_id');
            });
        }

        // Index on agents.agent_type_id for type filter
        if (!$this->indexExists('agents', 'idx_agents_agent_type_id')) {
            Schema::table('agents', function (Blueprint $table) {
                $table->index('agent_type_id', 'idx_agents_agent_type_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropIndexIfExists('visitors', 'idx_visitors_agents_id');
        $this->dropIndexIfExists('visitors', 'idx_visitors_agents_created');
        $this->dropIndexIfExists('foreign_jobs', 'idx_foreign_jobs_agents_id');
        $this->dropIndexIfExists('agents', 'idx_agents_filter');
        $this->dropIndexIfExists('agents', 'idx_agents_users_id');
        $this->dropIndexIfExists('agents', 'idx_agents_cities_id');
        $this->dropIndexIfExists('agents', 'idx_agents_agent_type_id');
    }

    /**
     * Check if an index exists on a table.
     */
    private function indexExists($table, $indexName)
    {
        $indexes = \DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$indexName]);
        return count($indexes) > 0;
    }

    /**
     * Drop an index if it exists.
     */
    private function dropIndexIfExists($table, $indexName)
    {
        if ($this->indexExists($table, $indexName)) {
            Schema::table($table, function (Blueprint $t) use ($indexName) {
                $t->dropIndex($indexName);
            });
        }
    }
}
