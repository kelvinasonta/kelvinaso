<?php

namespace Database\Seeders;

use App\Models\EmailSetting;
use App\Models\EmailTemplate;
use App\Models\Page;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Pages for authentication
        $this->call([
            AuthPageSeeder::class,
        ]);

        // 2. Administrators & Users
        $this->call([
            AdminSeeder::class,
        ]);

        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            Profile::updateOrCreate(
                ['user_id' => $adminUser->id],
                [
                    'first_name' => 'Kelvin',
                    'last_name' => 'Aso',
                    'bio_title' => 'Senior Fullstack Engineer & Software Architect',
                    'bio_header' => 'Crafting robust architectural solutions with an eye for exceptional visual detail.',
                    'bio' => 'Senior software engineer with over 7 years of deep experience designing high-throughput web applications, microservices, and modern user experiences.',
                    'bio_extra' => 'Specializing in Laravel, PHP 8.3+, React, TypeScript, Cloud Infrastructure, and Vector AI integrations.',
                    'avatar' => 'uploads/profiles/1786806425_chatgpt-image-jul-8-2026-01-36-31-pm.webp',
                    'cover_image' => 'uploads/profiles/1786793768_artful-media-dev-cycle-v2.webp',
                    'location' => 'Remote / Worldwide',
                    'direct_email' => 'admin@admin.com',
                    'direct_phone' => '+1 (555) 019-2834',
                    'cv' => 'uploads/cvs/1786809496_Fidelis_Ukwuani_CV.pdf',
                    'social_links' => [
                        'linkedin' => 'https://linkedin.com',
                        'github' => 'https://github.com',
                        'x' => 'https://x.com',
                        'facebook' => '',
                        'instagram' => '',
                    ],
                    'others' => ['meta' => null],
                ]
            );
        }

        // 3. Pages & Page Sections
        $pages = [
            'home' => [
                'title' => 'Home',
                'meta_description' => 'Home page of portfolio and engineering showcase.',
                'meta_keywords' => 'home, portfolio, developer, engineer, architecture',
                'sections' => [
                    [
                        'section_name' => 'profile_card',
                        'order' => 1,
                        'content' => [
                            'hero_title' => "I'm",
                            'hero_title_two' => 'a dedicated',
                            'hero_title_highlight' => 'Fullstack Architect',
                            'hero_title_suffix' => 'crafting resilient systems.',
                            'hero_meta' => 'Available for Freelancing & Consulting',
                        ],
                    ],
                    [
                        'section_name' => 'work_with_card',
                        'order' => 2,
                        'content' => [
                            'title' => 'Core Technologies & Tools',
                        ],
                    ],
                ],
            ],
            'projects' => [
                'title' => 'Projects',
                'meta_description' => 'Featured software development and architecture projects.',
                'meta_keywords' => 'projects, portfolio, laravel, react, cloud',
                'sections' => [
                    [
                        'section_name' => 'project_card',
                        'order' => 1,
                        'content' => [
                            'title' => 'Featured',
                            'title_highligted' => 'Engineering Works',
                            'subtitle' => 'Carefully architected applications built with modern engineering standards and scalable infrastructure.',
                            'categories' => [
                                'web' => 'Web Applications',
                                'mobile' => 'Mobile',
                                'cloud' => 'Cloud & DevOps',
                            ],
                        ],
                    ],
                ],
            ],
            'about' => [
                'title' => 'About',
                'meta_description' => 'Learn more about my background, career history, and software development philosophies.',
                'meta_keywords' => 'about, biography, background, fullstack, engineer',
                'sections' => [],
            ],
            'contact' => [
                'title' => 'Contact',
                'meta_description' => 'Get in touch for freelance projects, consulting, or technical advisory.',
                'meta_keywords' => 'contact, email, hire, developer, engineer',
                'sections' => [],
            ],
            'blog' => [
                'title' => 'Blog',
                'meta_description' => 'Articles and insights on web development, distributed architecture, and software design.',
                'meta_keywords' => 'blog, articles, tech, programming, laravel, architecture',
                'sections' => [
                    [
                        'section_name' => 'blog_card',
                        'order' => 1,
                        'content' => [
                            'title' => 'Technical',
                            'title_highligted' => 'Insights & Writing',
                            'subtitle' => 'Deep dives into modern web engineering, architecture design, and lessons learned from the field.',
                        ],
                    ],
                ],
            ],
            'snippets' => [
                'title' => 'Code Snippets',
                'meta_description' => 'Reusable code snippets, developer recipes, and software tricks.',
                'meta_keywords' => 'snippets, code, laravel, php, js, typescript',
                'sections' => [
                    [
                        'section_name' => 'snippets_card',
                        'order' => 1,
                        'content' => [
                            'title' => 'Code',
                            'title_highligted' => 'Snippets & Recipes',
                            'subtitle' => 'Curated solutions, architectural patterns, and production-tested code utilities.',
                        ],
                    ],
                ],
            ],
            'book-call' => [
                'title' => 'Book a Call',
                'meta_description' => 'Schedule a discovery call or technical consultation.',
                'meta_keywords' => 'book call, consultation, discovery, meeting',
                'sections' => [
                    [
                        'section_name' => 'book_call_card',
                        'order' => 1,
                        'content' => [
                            'title' => 'Schedule a',
                            'title_highligted' => 'Technical Consultation',
                            'subtitle' => 'Pick a suitable time slot on the calendar below to discuss your project requirements or system architecture.',
                        ],
                    ],
                ],
            ],
        ];

        foreach ($pages as $slug => $pageData) {
            $page = Page::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $pageData['title'],
                    'content' => [
                        'meta_description' => $pageData['meta_description'],
                        'meta_keywords' => $pageData['meta_keywords'],
                        'robots' => 'index, follow',
                    ],
                ]
            );

            if (!empty($pageData['sections'])) {
                foreach ($pageData['sections'] as $sec) {
                    $page->sections()->updateOrCreate(
                        ['section_name' => $sec['section_name']],
                        [
                            'order' => $sec['order'],
                            'content' => $sec['content'],
                        ]
                    );
                }
            }
        }

        // 4. App Settings
        $this->call([
            SettingSeeder::class,
        ]);

        // 5. Tech Stacks
        $this->call([
            StackSeeder::class,
        ]);

        // 6. Portfolio Projects
        $this->call([
            ProjectSeeder::class,
        ]);

        // 7. Work Experiences
        $this->call([
            ExperienceSeeder::class,
        ]);

        // 8. Blog Posts
        $this->call([
            PostSeeder::class,
        ]);

        // 9. Code Snippets
        $this->call([
            SnippetSeeder::class,
        ]);

        // 10. Sample Messages
        $this->call([
            ContactSeeder::class,
        ]);

        // 11. Email Settings & Templates
        EmailSetting::firstOrCreate([], [
            'header_html' => '<div style="background-color: #0f1016; padding: 24px; text-align: center; border-radius: 8px 8px 0 0;"><h1 style="color: #6c8eff; margin: 0; font-family: sans-serif;">Portfolio Systems</h1></div>',
            'footer_html' => '<div style="background-color: #f8fafc; padding: 18px; text-align: center; font-size: 12px; color: #64748b; border-radius: 0 0 8px 8px;"><p style="margin: 0;">© ' . date('Y') . ' Portfolio Systems. All rights reserved.</p></div>',
        ]);

        $templates = [
            [
                'slug' => 'contact_reply',
                'subject' => 'Re: {{ subject }} - Reply from Portfolio Systems',
                'body_html' => "<p>Hi {{ name }},</p>\n<p>Thank you for reaching out. Here is our response to your inquiry:</p>\n<blockquote style=\"border-left: 3px solid #10b981; padding-left: 12px; color: #555;\">{{ reply_message }}</blockquote>\n<p>Best regards,<br><strong>{{ sender_name }}</strong><br>Portfolio Systems</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'visitor_welcome',
                'subject' => 'Welcome to Portfolio Systems!',
                'body_html' => "<p>Hello {{ name }},</p>\n<p>Thank you for reaching out! We received your message regarding <strong>{{ subject }}</strong> and our team will get back to you shortly.</p>\n<p>Warm regards,<br>Portfolio Systems Team</p>",
                'is_active' => true,
            ],
            [
                'slug' => 'contact_form_email',
                'subject' => '{{ subject }}',
                'body_html' => "<p>{{ body }}</p>",
                'is_active' => true,
            ],
        ];

        foreach ($templates as $tmpl) {
            EmailTemplate::updateOrCreate(
                ['slug' => $tmpl['slug']],
                $tmpl
            );
        }
    }
}
