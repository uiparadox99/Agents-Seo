-- ================================================================
-- PERFORMANCE FIX: Add indexes to speed up admin/agents page
-- Run this on the LIVE server database to fix the 5-minute load time
-- ================================================================

-- 1. Index on visitors.agents_id (used by withCount visitors)
ALTER TABLE `visitors`
    ADD INDEX IF NOT EXISTS `idx_visitors_agents_id` (`agents_id`);

-- 2. Composite index on visitors (agents_id, created_at) for today-filter queries
ALTER TABLE `visitors`
    ADD INDEX IF NOT EXISTS `idx_visitors_agents_created` (`agents_id`, `created_at`);

-- 3. Index on foreign_jobs.agents_id (used by withCount foreignJobs)
ALTER TABLE `foreign_jobs`
    ADD INDEX IF NOT EXISTS `idx_foreign_jobs_agents_id` (`agents_id`);

-- 4. Composite index on agents for the common filter (is_foreign, active, deleted_at)
ALTER TABLE `agents`
    ADD INDEX IF NOT EXISTS `idx_agents_filter` (`is_foreign`, `active`, `deleted_at`);

-- 5. Index on agents.users_id (used in LEFT JOIN with users table)
ALTER TABLE `agents`
    ADD INDEX IF NOT EXISTS `idx_agents_users_id` (`users_id`);

-- 6. Index on agents.cities_id (used for city filter)
ALTER TABLE `agents`
    ADD INDEX IF NOT EXISTS `idx_agents_cities_id` (`cities_id`);

-- 7. Index on agents.agent_type_id (used for type filter)
ALTER TABLE `agents`
    ADD INDEX IF NOT EXISTS `idx_agents_agent_type_id` (`agent_type_id`);

-- Verify indexes were created:
-- SHOW INDEX FROM visitors;
-- SHOW INDEX FROM foreign_jobs;
-- SHOW INDEX FROM agents;
