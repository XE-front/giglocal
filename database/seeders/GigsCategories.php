<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GigsCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Home Services',
                'description' => 'Repairs, maintenance, and improvement services for homes and properties.',
                'icon' => 'fa-house',
            ],
            [
                'name' => 'Tutoring & Education',
                'description' => 'Private lessons, academic help, and educational support.',
                'icon' => 'fa-book',
            ],
            [
                'name' => 'Errand & Delivery',
                'description' => 'Running errands, delivery, and courier services.',
                'icon' => 'fa-motorcycle',
            ],
            [
                'name' => 'Cleaning Services',
                'description' => 'Residential and commercial cleaning, janitorial, and sanitation.',
                'icon' => 'fa-broom',
            ],
            [
                'name' => 'Tech & IT Services',
                'description' => 'Technical support, IT consulting, and computer repair.',
                'icon' => 'fa-laptop',
            ],
            [
                'name' => 'Creative & Freelance',
                'description' => 'Design, writing, photography, and other freelance creative work.',
                'icon' => 'fa-paint-brush',
            ],
            [
                'name' => 'Beauty & Personal Care',
                'description' => 'Hair, makeup, spa, and wellness services.',
                'icon' => 'fa-spa',
            ],
            [
                'name' => 'Construction & Labor',
                'description' => 'Building, renovation, and manual labor services.',
                'icon' => 'fa-hard-hat',
            ],
            [
                'name' => 'Transport & Moving',
                'description' => 'Moving, hauling, and transportation services.',
                'icon' => 'fa-truck',
            ],
            [
                'name' => 'Pet Services',
                'description' => 'Pet care, grooming, walking, and sitting.',
                'icon' => 'fa-dog',
            ],
            [
                'name' => 'Event & Services',
                'description' => 'Event planning, catering, and related services.',
                'icon' => 'fa-champagne-glasses',
            ],
            [
                'name' => 'Others',
                'description' => 'Miscellaneous services not listed above.',
                'icon' => 'fa-toolbox',
            ],
        ];

        foreach ($categories as $category) {
            \DB::table('gigs_categories')->insert([
                'name' => $category['name'],
                'description' => $category['description'],
                'icon' => $category['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
