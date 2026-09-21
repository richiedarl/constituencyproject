<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidatePosition;
use App\Models\Project;
use App\Models\ProjectPhase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KingsleyMoghaluSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'kingsley.moghalu@example.test'],
            [
                'name' => 'Kingsley Moghalu',
                'username' => 'kingsley-moghalu',
                'role' => 'candidate',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->forceFill([
            'admin' => false,
            'candidate' => true,
            'contributor' => false,
        ])->save();

        $candidate = Candidate::updateOrCreate(
            ['email' => 'kingsley.moghalu@example.test'],
            [
                'user_id' => $user->id,
                'name' => 'Kingsley Moghalu',
                'slug' => 'kingsley-moghalu',
                'phone' => null,
                'district' => 'Anambra Central Senatorial District',
                'state' => 'Anambra',
                'gender' => 'male',
                'bio' => 'Kingsley Moghalu is a Nigerian politician and public policy advocate. This profile and its project are demonstration data for testing the platform.',
                'photo' => 'fe/assets/img/static_candidates/kingsley_moghalu.jpg',
                'paid' => true,
                'approved' => true,
            ]
        );

        CandidatePosition::updateOrCreate(
            [
                'candidate_id' => $candidate->id,
                'position' => 'Politician',
            ],
            [
                'year_from' => 2018,
                'year_until' => null,
                'is_current' => true,
            ]
        );

        $project = Project::updateOrCreate(
            ['slug' => 'community-enterprise-skills-hub-demo'],
            [
                'candidate_id' => $candidate->id,
                'title' => 'Community Enterprise and Skills Hub (Demo)',
                'description' => 'Demonstration project for testing how a candidate initiative is displayed, tracked, and opened to contributors and contractors on the platform.',
                'short_description' => 'A demonstration skills and enterprise hub used to test the complete public project flow.',
                'type' => 'Skills development',
                'status' => 'ongoing',
                'state' => 'Anambra',
                'lga' => 'Awka South',
                'ward' => 'Central Ward',
                'community' => 'Awka',
                'address' => 'Awka, Anambra State',
                'start_date' => now()->subMonths(2)->startOfMonth(),
                'completion_date' => now()->addMonths(6)->endOfMonth(),
                'estimated_budget' => 75000000,
                'actual_cost' => 18000000,
                'contractor_count' => 1,
                'featured_image' => null,
                'paid' => true,
                'is_public' => true,
                'is_active' => true,
                'created_by' => $user->id,
            ]
        );

        // Project model creation rules default CLI-created projects to inactive.
        $project->forceFill(['is_active' => true, 'is_public' => true])->save();

        ProjectPhase::updateOrCreate(
            [
                'project_id' => $project->id,
                'phase' => 'planning',
            ],
            [
                'status' => 'Completed',
                'description' => 'Community consultation, needs assessment, and project planning.',
                'weight' => 25,
                'started_at' => now()->subMonths(2),
                'ended_at' => now()->subMonth(),
                'created_by' => $user->id,
            ]
        );

        ProjectPhase::updateOrCreate(
            [
                'project_id' => $project->id,
                'phase' => 'executing',
            ],
            [
                'status' => 'In progress',
                'description' => 'Facility preparation and procurement of training equipment.',
                'weight' => 75,
                'started_at' => now()->subMonth(),
                'ended_at' => null,
                'created_by' => $user->id,
            ]
        );
    }
}
