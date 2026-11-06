<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Designing Scalable Modular Systems with Laravel & Modern PHP',
                'slug' => 'designing-scalable-modular-systems-laravel-modern-php',
                'excerpt' => 'A practical walkthrough on organizing large-scale Laravel codebases using service layers, domain actions, and clean architecture principles.',
                'content' => "<p>Building large-scale web applications requires more than just knowing framework syntax. As codebases grow, sticking strictly to standard MVC can lead to bloated controllers and brittle models.</p><h2>The Solution: Modular Service Patterns</h2><p>By extracting business logic into dedicated Action classes and Domain Services, every piece of business logic becomes reusable, testable in isolation, and decoupled from HTTP concerns.</p><pre><code>// Example Action Pattern\nfinal class RegisterUserAction {\n    public function execute(UserData \$data): User {\n        // atomic user creation with events\n    }\n}</code></pre><h2>Summary</h2><p>Clean boundaries save teams hundreds of debugging hours as products scale to enterprise volumes.</p>",
                'cover_image' => 'uploads/blog/1786788700_screenshot-2026-08-13-at-53808-am.webp',
                'category' => 'Architecture',
                'tags' => ['Laravel', 'Architecture', 'PHP 8.3', 'Best Practices'],
                'read_time' => '6 min read',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
                'views_count' => 142,
            ],
            [
                'title' => 'Mastering Real-Time WebSockets and Queues Under Load',
                'slug' => 'mastering-real-time-websockets-and-queues-under-load',
                'excerpt' => 'How to optimize event broadcasting, Redis queue throughput, and worker daemon management for mission-critical web applications.',
                'content' => "<p>Real-time notifications and live updates are table stakes in modern software. However, running websockets at scale introduces concurrency challenges, connection drops, and Redis backpressure.</p><h2>Queue Optimization Techniques</h2><p>Always partition high-priority queues away from background tasks like email dispatching. Using Redis cluster nodes ensures persistent connection pooling without bottlenecking web requests.</p>",
                'cover_image' => 'uploads/blog/1786788700_screenshot-2026-08-13-at-53808-am.webp',
                'category' => 'Backend',
                'tags' => ['Redis', 'WebSockets', 'Concurrency', 'DevOps'],
                'read_time' => '8 min read',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(12),
                'views_count' => 285,
            ],
            [
                'title' => 'Building Polished Bento Grid Interfaces with CSS Grid & Tailwind',
                'slug' => 'building-polished-bento-grid-interfaces-css-grid-tailwind',
                'excerpt' => 'Creating visually stunning, responsive bento grid layouts that fluidly adapt across mobile, tablet, and ultra-wide screens.',
                'content' => "<p>Bento grids have become one of the most effective UI visual styles for showcasing multi-faceted products and developer portfolios. Let's look at structuring CSS Grid with fluid clamp values and accessible keyboard navigation.</p>",
                'cover_image' => 'uploads/blog/1786788700_screenshot-2026-08-13-at-53808-am.webp',
                'category' => 'Frontend',
                'tags' => ['CSS', 'Tailwind', 'UI/UX', 'Design'],
                'read_time' => '4 min read',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(20),
                'views_count' => 512,
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );
        }
    }
}

