<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Construction Skills
            ['name' => 'Carpentry', 'category' => 'construction'],
            ['name' => 'Masonry', 'category' => 'construction'],
            ['name' => 'Plumbing', 'category' => 'construction'],
            ['name' => 'Electrical Wiring', 'category' => 'construction'],
            ['name' => 'Painting', 'category' => 'construction'],
            ['name' => 'Roofing', 'category' => 'construction'],
            ['name' => 'Welding', 'category' => 'construction'],
            ['name' => 'HVAC', 'category' => 'construction'],

            // Engineering Skills
            ['name' => 'Civil Engineering', 'category' => 'engineering'],
            ['name' => 'Structural Engineering', 'category' => 'engineering'],
            ['name' => 'Architectural Design', 'category' => 'engineering'],
            ['name' => 'Project Management', 'category' => 'management'],

            // Specialized Skills
            ['name' => 'Heavy Equipment Operation', 'category' => 'specialized'],
            ['name' => 'Surveying', 'category' => 'specialized'],
            ['name' => 'Safety Inspection', 'category' => 'specialized'],
            ['name' => 'Quality Control', 'category' => 'specialized'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
