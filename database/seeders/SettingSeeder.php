<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Portfolio Systems',
            'site_tagline' => 'Senior Fullstack Engineer & Architecture Specialist',
            'site_description' => 'Personal portfolio and technical showcase featuring projects, engineering articles, and reusable architectural patterns.',
            'site_keywords' => 'laravel, vue, react, fullstack, developer, architecture, php, portfolio',
            'contact_email' => 'admin@admin.com',
            'footer_copyright' => 'Copyright © ' . date('Y') . ', Portfolio Systems. All Rights Reserved.',
            'footer_cta_title' => 'Are You Ready to kickstart your project with a touch of magic?',
            'footer_cta_description' => "Reach out and let's make it happen ✨. I'm also available for full-time or freelance opportunities to push the boundaries of software and deliver exceptional products.",
            'footer_cta_button_text' => "Let's Talk",
            'footer_cta_button_url' => '/contact',
            'primary_color' => '#f0563a',
            'accent_color' => '#db391c',
            'secondary_color' => '#6366f1',
            'enable_experiences' => '1',
            'enable_snippets' => '1',
            'enable_scheduler' => '1',
            'enable_blog' => '1',
            'enable_ai_chatbot' => '1',
            'enable_github_sync' => '0',
            'calendly_url' => 'https://calendly.com',
            'github_username' => 'kelvin-portfolio',
        ];

        foreach ($settings as $key => $value) {
            Settings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}

