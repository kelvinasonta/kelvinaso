<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Portfolio Portfolio',
                'slug' => 'Portfolio-portfolio',
                'description' => 'A fast, modular developer portfolio and CMS architecture featuring high-speed page caching, SEO optimization, and an administrative control panel.',
                'image' => 'uploads/projects/1786786324_screenshot-2026-08-13-at-53818-am.webp',
                'icon' => 'https://cdn.simpleicons.org/laravel/ffffff',
                'tech_stack' => ['Laravel', 'PHP', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
                'role' => 'Lead Fullstack Architect',
                'year' => 2026,
                'industry' => 'Software & Web',
                'client' => 'QWE Systems',
                'client_url' => 'https://qwesystems.com',
                'client_comment' => [
                    'comment' => "The Ledger API rollout was flawless. Asonta delivered a robust, lightning-fast architecture that handles our peak transaction periods without breaking a sweat. It's the most stable part of our stack.",
                    'position' => 'CEO',
                    'poition' => 'CEO',
                    'name' => 'Sam Ergu'
                ],
                'github_url' => 'https://github.com/username/portfolio-portfolio',
                'project_type' => 'web',
                'view_type' => 'live',
                'live_url' => 'https://portfolio.example.com',
                'featured' => true,
                'order' => 1,
                'is_active' => true,
                'metrics' => [
                    'Throughput' => '8k rps',
                    'Test coverage' => '94%',
                    'Status' => 'Good'
                ],
                'other_details' => [
                    [
                        'header' => 'The Challenge',
                        'paragrah' => 'Atlas Fintech was struggling with database deadlocks and slow transaction posting as their user base rapidly scaled. Their legacy architecture could not guarantee atomicity under high concurrent load, risking out-of-sync balances. They needed a hyper-fast, rock-solid core ledger capable of processing thousands of financial events per minute without dropping or duplicating a single record.',
                        'order' => 1,
                        'is_active' => true,
                    ],
                    [
                        'header' => 'Architecture & Approach',
                        'paragrah' => 'I engineered a strict double-entry accounting system where every transaction enforces balanced debits and credits at the database level. To achieve the required sub-50ms latency, the API is served via Laravel Octane (powered by Swoole), keeping the framework booted in memory and drastically reducing overhead. State mutations utilize aggressive pessimistic locking (SELECT ... FOR UPDATE) within PostgreSQL to ensure absolute ACID compliance during concurrent postings.',
                        'order' => 2,
                        'is_active' => true,
                    ],
                    [
                        'header' => 'The Results',
                        'paragrah' => "The new Ledger API launched seamlessly, migrating over 2 million historical accounts with zero downtime. API throughput increased by 800% while server resources were slashed in half thanks to Octane's raw efficiency.",
                        'order' => 3,
                        'is_active' => true,
                    ]
                ],
            ],
            [
                'title' => 'SaaS Cloud Metrics Dashboard',
                'slug' => 'saas-cloud-metrics-dashboard',
                'description' => 'Real-time multi-tenant monitoring application with high-throughput event processing, alerting workflows, and custom analytics telemetry.',
                'image' => 'uploads/projects/1786786324_screenshot-2026-08-13-at-53818-am.webp',
                'icon' => 'https://cdn.simpleicons.org/laravel/ffffff',
                'tech_stack' => ['Laravel', 'PostgreSQL', 'Tailwind CSS', 'Redis', 'Alpine.js'],
                'role' => 'Lead Fullstack Architect',
                'year' => 2026,
                'industry' => 'Cloud Infrastructure',
                'client' => 'Apex Cloud Labs',
                'client_url' => 'https://example.com',
                'client_comment' => [
                    'author' => 'Sarah Lin',
                    'name' => 'Sarah Lin',
                    'position' => 'CTO',
                    'title' => 'CTO at Apex Cloud Labs',
                    'comment' => 'Exceptional delivery on tight milestones. The platform easily handles millions of daily data points with sub-100ms latency.'
                ],
                'github_url' => 'https://github.com',
                'project_type' => 'web',
                'view_type' => 'live',
                'live_url' => 'https://example.com',
                'featured' => true,
                'order' => 2,
                'is_active' => true,
                'metrics' => [
                    'Throughput' => '5,000 req/sec',
                    'Uptime' => '99.98%',
                    'Latency' => '< 85ms'
                ],
                'other_details' => [
                    [
                        'header' => 'Telemetry Processing',
                        'paragrah' => 'Designed architecture utilizing queue workers, Redis caches, and optimized database indexing to provide real-time updates.',
                        'order' => 1,
                        'is_active' => true,
                    ]
                ],
            ],
            [
                'title' => 'Artisan E-Commerce Storefront',
                'slug' => 'artisan-ecommerce-storefront',
                'description' => 'High-converting omnichannel digital commerce experience with dynamic cart state, Stripe checkout, automated tax calculation, and order tracking.',
                'image' => 'uploads/projects/1786786324_screenshot-2026-08-13-at-53818-am.webp',
                'icon' => 'https://cdn.simpleicons.org/react/ffffff',
                'tech_stack' => ['Laravel', 'React', 'Inertia.js', 'Stripe', 'MySQL'],
                'role' => 'Fullstack Developer',
                'year' => 2025,
                'industry' => 'E-Commerce',
                'client' => 'Nordic Goods Co',
                'client_url' => 'https://example.com',
                'client_comment' => [
                    'author' => 'David Miller',
                    'name' => 'David Miller',
                    'position' => 'Founder',
                    'title' => 'Founder',
                    'comment' => 'Our checkout abandonment dropped by 34% within the first month after the redesign launch.'
                ],
                'github_url' => 'https://github.com',
                'project_type' => 'web',
                'view_type' => 'live',
                'live_url' => 'https://example.com',
                'featured' => true,
                'order' => 3,
                'is_active' => true,
                'metrics' => [
                    'Conversion Rate' => '+34%',
                    'Page Load' => '0.8s',
                    'Orders Processed' => '50,000+'
                ],
                'other_details' => [
                    [
                        'header' => 'Checkout Architecture',
                        'paragrah' => 'Integrated secure payment webhooks, stock synchronization, and customer self-service portals.',
                        'order' => 1,
                        'is_active' => true,
                    ]
                ],
            ],
            [
                'title' => 'AI Knowledge Copilot & Search',
                'slug' => 'ai-knowledge-copilot-search',
                'description' => 'Semantic retrieval engine utilizing vector embeddings and LLM tool calling to automate internal corporate policy and code navigation.',
                'image' => 'uploads/projects/1786786324_screenshot-2026-08-13-at-53818-am.webp',
                'icon' => 'https://cdn.simpleicons.org/openai/ffffff',
                'tech_stack' => ['PHP', 'Python', 'Vector DB', 'Laravel', 'TypeScript'],
                'role' => 'AI Engineer & Backend Lead',
                'year' => 2026,
                'industry' => 'Artificial Intelligence',
                'client' => 'Synth Labs',
                'client_url' => 'https://example.com',
                'client_comment' => [
                    'author' => 'Elena Rostova',
                    'name' => 'Elena Rostova',
                    'position' => 'Head of Engineering',
                    'title' => 'Head of Engineering',
                    'comment' => 'Transformed our internal onboarding process. Engineers now get instant answers with exact doc references.'
                ],
                'github_url' => 'https://github.com',
                'project_type' => 'web',
                'view_type' => 'live',
                'live_url' => 'https://example.com',
                'featured' => true,
                'order' => 4,
                'is_active' => true,
                'metrics' => [
                    'Accuracy' => '96.4%',
                    'Query Time' => '420ms',
                    'Docs Indexed' => '120k+'
                ],
                'other_details' => [
                    [
                        'header' => 'RAG Pipeline Design',
                        'paragrah' => 'Built with streaming responses, conversation state management, and fallback prompt chains.',
                        'order' => 1,
                        'is_active' => true,
                    ]
                ],
            ],
        ];

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }
    }
}
