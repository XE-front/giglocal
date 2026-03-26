<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangays = [
            'Lagao',
            'Calumpang',
            'Apopong',
            'Fatima',
            'Labangal',
            'Bula',
            'Dadiangas North',
            'Dadiangas South',
            'Mabuhay',
            'Baluan',
            'Batomelong',
            'Buayan',
            'City Heights',
            'Dadiangas East',
            'Conel',
            'Dadiangas West',
            'Katangawan',
            'Ligaya',
            'Olympog',
            'San Isidro',
            'San Jose',
            'Siguel',
            'Sinawal',
            'Tambler',
            'Upper Labay',
        ];

        foreach ($barangays as $barangay) {
            \DB::table('barangays')->insert([
                'barangay_name' => $barangay,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
