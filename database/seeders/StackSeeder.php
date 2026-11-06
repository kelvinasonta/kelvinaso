<?php

namespace Database\Seeders;

use App\Models\Stack;
use App\Models\User;
use Illuminate\Database\Seeder;

class StackSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        if (!$admin) {
            return;
        }

        $stacks = [
            // Languages
            [
                'name' => 'PHP',
                'type' => 'Language',
                'color' => '#777bb4',
                'level' => 'Advanced',
                'is_lang' => true,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'JavaScript',
                'type' => 'Language',
                'color' => '#f7df1e',
                'level' => 'Advanced',
                'is_lang' => true,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'TypeScript',
                'type' => 'Language',
                'color' => '#3178c6',
                'level' => 'Advanced',
                'is_lang' => true,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Python',
                'type' => 'Language',
                'color' => '#3776ab',
                'level' => 'Intermediate',
                'is_lang' => true,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'SQL',
                'type' => 'Language',
                'color' => '#e38c00',
                'level' => 'Advanced',
                'is_lang' => true,
                'is_active' => true,
                'image' => null,
            ],

            // Frameworks & Libraries
            [
                'name' => 'Laravel',
                'type' => 'Framework',
                'color' => '#ff2d20',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'React',
                'type' => 'Framework',
                'color' => '#61dafb',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Vue.js',
                'type' => 'Framework',
                'color' => '#42b883',
                'level' => 'Intermediate',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Tailwind CSS',
                'type' => 'Framework',
                'color' => '#06b6d4',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Next.js',
                'type' => 'Framework',
                'color' => '#000000',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],

            // Tools, Databases & DevOps
            [
                'name' => 'PostgreSQL',
                'type' => 'Database',
                'color' => '#4169e1',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'MySQL',
                'type' => 'Database',
                'color' => '#4479a1',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Redis',
                'type' => 'Database',
                'color' => '#dc382d',
                'level' => 'Intermediate',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Docker',
                'type' => 'DevOps',
                'color' => '#2496ed',
                'level' => 'Intermediate',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
            [
                'name' => 'Git',
                'type' => 'DevOps',
                'color' => '#f05032',
                'level' => 'Advanced',
                'is_lang' => false,
                'is_active' => true,
                'image' => null,
            ],
        ];

        foreach ($stacks as $stackData) {
            Stack::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'name' => $stackData['name'],
                ],
                $stackData
            );
        }
    }
}

