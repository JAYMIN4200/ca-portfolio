<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function columns(): array
    {
        $timestamps = ['created_at', 'updated_at'];

        return [
            'assignments' => $timestamps,
            'blog_posts' => [...$timestamps, 'published_at'],
            'case_studies' => $timestamps,
            'clients' => $timestamps,
            'client_works' => $timestamps,
            'contact_messages' => $timestamps,
            'expenses' => $timestamps,
            'experiences' => $timestamps,
            'failed_jobs' => ['failed_at'],
            'faqs' => $timestamps,
            'meetings' => $timestamps,
            'password_reset_tokens' => ['created_at'],
            'payments' => $timestamps,
            'profiles' => $timestamps,
            'qualifications' => $timestamps,
            'services' => $timestamps,
            'settings' => $timestamps,
            'skills' => $timestamps,
            'skill_categories' => $timestamps,
            'tasks' => [...$timestamps, 'completed_at'],
            'terms' => $timestamps,
            'testimonials' => $timestamps,
            'users' => [...$timestamps, 'email_verified_at', 'last_login_at'],
            'visits' => $timestamps,
        ];
    }

    private function expression(string $column, int $minutes): string
    {
        return match (DB::connection()->getDriverName()) {
            'sqlite' => "datetime(`{$column}`, '{$minutes} minutes')",
            'pgsql' => "`{$column}` + interval '{$minutes} minutes'",
            'sqlsrv' => "DATEADD(MINUTE, {$minutes}, `{$column}`)",
            default => "DATE_ADD(`{$column}`, INTERVAL {$minutes} MINUTE)",
        };
    }

    private function shift(int $minutes): void
    {
        foreach ($this->columns() as $table => $columns) {
            foreach ($columns as $column) {
                DB::statement(
                    "UPDATE `{$table}` SET `{$column}` = {$this->expression($column, $minutes)} WHERE `{$column}` IS NOT NULL"
                );
            }
        }
    }

    /**
     * Shift existing stored timestamps from the old UTC wall-clock to
     * Asia/Kolkata because the app timezone is changing.
     */
    public function up(): void
    {
        $this->shift(330);
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        $this->shift(-330);
    }
};
