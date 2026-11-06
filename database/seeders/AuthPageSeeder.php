<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class AuthPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loginPage = Page::updateOrCreate(
            ['slug' => 'login'],
            [
                'title' => 'Login',
                'content' => [
                    'meta_description' => 'Login to your account',
                    'meta_keywords' => 'login, account, Portfolio Systems',
                ]
            ]
        );

        $loginPage->sections()->updateOrCreate(
            ['section_name' => 'auth_card'],
            [
                'order' => 1,
                'content' => [
                    'title' => 'Login to your account',
                    'subtitle' => 'Please enter your credentials to login.',
                    'button_text' => 'Login',
                    'forgot_password_text' => 'Forgot your password?',
                    'register_text' => "Don't have an account?",
                ]
            ]
        );

        $registerPage = Page::updateOrCreate(
            ['slug' => 'register'],
            [
                'title' => 'Register',
                'content' => [
                    'meta_description' => 'Create a new account',
                    'meta_keywords' => 'register, account, Portfolio Systems',
                ]
            ]
        );

        $registerPage->sections()->updateOrCreate(
            ['section_name' => 'auth_card'],
            [
                'order' => 1,
                'content' => [
                    'title' => 'Create a new account',
                    'subtitle' => 'Please fill in the details to create your account.',
                    'button_text' => 'Register',
                    'login_text' => "Already have an account?",
                ]
            ]
        );

        $resetPage = Page::updateOrCreate(
            ['slug' => 'reset-password'],
            [
                'title' => 'Reset Password',
                'content' => [
                    'meta_description' => 'Reset your password',
                    'meta_keywords' => 'reset, password, Portfolio Systems',
                ]
            ]
        );

        $resetPage->sections()->updateOrCreate(
            ['section_name' => 'auth_card'],
            [
                'order' => 1,
                'content' => [
                    'title' => 'Reset your password',
                    'subtitle' => 'Please enter your email address to reset your password.',
                    'button_text' => 'Reset Password',
                    'login_text' => "Already have an account?"
                ]
            ]
        );
    }
}
