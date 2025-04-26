<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Novo'],
            ['name' => 'Pendente'],
            ['name' => 'Resolvido']
        ];

        foreach ($statuses as $status) {
            $exists = Status::where('name', $status['name'])->exists();
            if (!$exists) {
                Status::create($status);
            }
        }
    }
}