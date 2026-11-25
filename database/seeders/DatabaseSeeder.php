<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PanosoganPilotSeeder::class,
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@taniamanah.id'],
            [
                'name' => 'Superadmin Tani Amanah',
                'password' => 'password',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Superadmin',
                'password' => 'password',
            ]
        );
    }
}
