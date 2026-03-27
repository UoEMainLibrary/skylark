<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;

/**
 * Optionally creates or updates a User that can log into Filament.
 *
 * Set FILAMENT_ADMIN_EMAIL and FILAMENT_ADMIN_PASSWORD in .env before running
 * migrations on a fresh database. The User model's "hashed" cast hashes the
 * password on save (bcrypt by default). The plain password is never stored in code.
 *
 * If either variable is missing, this migration does nothing (safe for CI/tests).
 * To add an admin later, set the variables and run:
 * php artisan migrate:rollback --step=1 && php artisan migrate
 * or use php artisan make:filament-user.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $email = env('FILAMENT_ADMIN_EMAIL');
        $password = env('FILAMENT_ADMIN_PASSWORD');

        if (! is_string($email) || $email === '' || ! is_string($password) || $password === '') {
            return;
        }

        if (strlen($password) < 12) {
            throw new RuntimeException(
                'FILAMENT_ADMIN_PASSWORD must be at least 12 characters when set.'
            );
        }

        $name = env('FILAMENT_ADMIN_NAME', 'Admin');
        if (! is_string($name) || $name === '') {
            $name = 'Admin';
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $email = env('FILAMENT_ADMIN_EMAIL');

        if (! is_string($email) || $email === '') {
            return;
        }

        User::query()->where('email', $email)->delete();
    }
};
