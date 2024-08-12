<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/json/divisions.json'));
        $divisions = json_decode($json, true);

        $payload = [];
        foreach ($divisions as $division) {
            $payload[] = [
                'id' => Uuid::uuid4()->toString(),
                'name' => $division['name'],
            ];
        }

        DB::table('divisions')->insert($payload);
    }
}
