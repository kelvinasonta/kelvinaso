<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Alexander Wright',
                'email' => 'alex.wright@fintechventures.io',
                'subject' => 'Enterprise API Architecture Inquiry',
                'message' => 'Hello Kelvin, We came across your portfolio and were really impressed by your backend systems work. We are planning a multi-tenant payment system redesign and would love to discuss your availability for a contract or consulting role.',
                'status' => 'unread',
            ],
            [
                'name' => 'Sophia Chen',
                'email' => 'sophia@creativestudios.co',
                'subject' => 'Fullstack Laravel & React Collaboration',
                'message' => 'Hi Kelvin! We have an upcoming client project requiring a polished Bento-style dashboard with real-time analytics. Are you open to scheduling a quick discovery call next week?',
                'status' => 'read',
            ],
            [
                'name' => 'Liam O\'Connor',
                'email' => 'liam@growthmetrics.com',
                'subject' => 'Question about SaaS Cloud Metrics Dashboard',
                'message' => 'Hey there, loved your project write-up on high-throughput queue optimization. Wanted to ask which queue driver setup worked best for your latency requirements.',
                'status' => 'replied',
            ],
        ];

        foreach ($messages as $msg) {
            Contact::firstOrCreate(
                [
                    'email' => $msg['email'],
                    'subject' => $msg['subject'],
                ],
                $msg
            );
        }
    }
}

