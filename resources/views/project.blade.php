@php

    $projectCard = $page->sections->where('section_name', 'project_card')->first();

@endphp


<x-main-layout :page="$page">


    <section class="works" id="works" data-per-page="6">



        <div class="works-head animate-up delay-1">
            <h2>{{ $projectCard->content['title'] }}<span class="text-gradient">
                    {{ $projectCard->content['title_highligted'] }}</span></h2>
            <p>{{ $projectCard->content['subtitle'] }}</p>
        </div>

        @if (false)
            <div class="tabs" animate-up delay-2>
                <button class="tab active" data-tab="All">All</button>
                @foreach ($projectCard->content['categories'] as $category => $name)
                    <button class="tab" data-tab="{{ $category }}">{{ $name }}</button>
                @endforeach

            </div>
        @endif

        <div class="grid-bento" animate-up delay-4>

            @foreach ($projects as $project)
                @if ($project->is_active)
                    <a href="/projects/{{ $project->slug }}" class="card work-card" data-work
                        data-category="{{ $project->project_type }}">
                        <div class="work-cover"><img
                                src="{{ str_starts_with($project->icon, 'https') ? $project->icon : asset($project->image) }}"
                                alt="{{ $project->title }}" loading="lazy" />
                        </div>
                        <div class="work-body">
                            <p class="work-tag"></p>
                            <h3 class="work-title">{{ $project->title }}</h3>
                            <p class="work-summary">{{ $project->description }}</p>
                        </div>
                    </a>
                @endif
            @endforeach

        </div>
        <div class="pagination" data-pagination></div>
    </section>

</x-main-layout>
