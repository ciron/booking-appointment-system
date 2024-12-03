<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Patient::create([
            'name' => 'Patient 1',
            'email' => 'patient@gmail.com',
            'password' => Hash::make('123456'),  // Hash the password
            // Add other fields as necessary, e.g. 'name', 'dob', etc.
        ]);

        // Seed for Doctor
        Doctor::create([
            'name' => 'Doctor 1',
            'specialization' => 'Heart',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('123456'),  // Hash the password
            // Add other fields as necessary, e.g. 'name', 'specialization', etc.
        ]);
    }
}
