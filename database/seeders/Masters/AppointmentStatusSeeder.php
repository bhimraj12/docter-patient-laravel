<?php

namespace Database\Seeders\Masters;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints
        Schema::disableForeignKeyConstraints();
        DB::table('table_name')->truncate();
        // Enable foreign key constraints
        Schema::enableForeignKeyConstraints();

        $masters = [
            //data
        ];

        foreach ($masters as $master) {
            Model::create([
                'name' => $master,
                'slug' => str_slug($master),
            ]);
        }
    }
}
