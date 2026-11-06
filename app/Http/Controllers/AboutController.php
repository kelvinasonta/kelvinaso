<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page; 
use App\Models\Experience; 
use App\Services\GitHubService;  

class AboutController extends Controller
{
    public function index()
    {
        $users = $this->users;

        $stacks = $this->users ? $this->users->stacks()->where('is_active', true)->get()->groupBy('type')->toArray() : [];

        $page = Page::where('slug', 'about')->first() ?? Page::where('slug', 'home')->first();

        $profile = $this->users ? $this->users->profile()->first() : null;

        $experiences = setting('enable_experiences')
            ? Experience::where('is_active', true)->get()
            : collect();
        
        $githubProjects = [];
        
        if (setting('enable_github_sync') && setting('github_username')) {
            $gitHubService = app(GitHubService::class);
            $githubProjects = $gitHubService->getUserRepositories(setting('github_username')) ?? [];
        }

        
        return view('about', compact('users', 'page', 'profile', 'stacks', 'experiences', 'githubProjects'));
    }
}
