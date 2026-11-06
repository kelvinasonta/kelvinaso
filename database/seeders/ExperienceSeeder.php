<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'title' => 'Senior Fullstack Engineer',
                'company' => 'Apex Cloud Systems',
                'location' => 'Remote / San Francisco, CA',
                'employment_type' => 'Full-time',
                'start_year' => '2024',
                'end_year' => null,
                'is_current' => true,
                'description' => 'Architected enterprise cloud telemetry and microservices using Laravel, Redis, and React. Spearheaded system scalability to handle 10M+ daily events.',
                'is_active' => true,
            ],
            [
                'title' => 'Lead Web Developer',
                'company' => 'Vanguard Digital Agency',
                'location' => 'New York, NY',
                'employment_type' => 'Full-time',
                'start_year' => '2021',
                'end_year' => '2024',
                'is_current' => false,
                'description' => 'Led a team of 6 engineers delivering custom SaaS portals, e-commerce applications, and high-performance APIs. Maintained 99.9% uptime and streamlined CI/CD pipelines.',
                'is_active' => true,
            ],
            [
                'title' => 'Backend Software Engineer',
                'company' => 'Kora Labs',
                'location' => 'Austin, TX',
                'employment_type' => 'Full-time',
                'start_year' => '2019',
                'end_year' => '2021',
                'is_current' => false,
                'description' => 'Engineered payment integrations, database migrations, and RESTful web services. Optimized complex query performance and implemented caching strategies.',
                'is_active' => true,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                [
                    'title' => $exp['title'],
                    'company' => $exp['company'],
                ],
                $exp
            );
        }
    }
}

