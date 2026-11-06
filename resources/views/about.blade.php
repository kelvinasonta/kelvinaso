@php
    $profileCard = $page->sections->where('section_name', 'profile_card')->first();
    $workWith = $page->sections->where('section_name', 'work_with_card')->first();

@endphp


<x-main-layout :page="$page">

    <section class="hero" style="position: relative;">

        <x-profile-card-component :profile="$profile" />





        <div style="display:flex; flex-direction:column; gap:4rem;">
            <div class="card hero-card">
                <p class="eyebrow">Biography</p>
                <h1 style="margin-top:1.25rem;">{{ $profile->bio_header ?? '' }} <span class="text-gradient">read the
                        data</span> </h1>
                <div
                    style="margin-top:2rem; color:var(--muted); font-size:1.1rem; line-height:1.7; max-width:60ch; display:flex; flex-direction:column; gap:1.25rem;">
                    <p>{{ $profile->bio }}</p>
                    <p>{{ $profile->bio_extra ?? '' }}</p>
                </div>
            </div>

            <section>
                <h2 style="margin-bottom:2rem;">Skills</h2>
                <div class="skills-grid">

                    @foreach ($stacks as $stack => $values)
                        <div class="card skill-card">
                            <p class="eyebrow">{{ $stack }}</p>
                            <ul>
                                @foreach ($values as $value)
                                    <li>{{ $value['name'] }} <span
                                            class="skill-level {{ strtolower($value['level'] ?? 'intermidiate') }}">{{ $value['level'] ?? 'intermidiate' }}</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    @endforeach

                </div>
            </section>


            @if (setting('enable_experiences') && $experiences->isNotEmpty())
                <section>
                    <h2 style="margin-bottom:2rem;">Experience</h2>

                    <ul class="experience">
                        @foreach ($experiences as $exp)
                            <li>
                                <span class="year">{{ $exp->start_year }} —
                                    {{ $exp->is_current ? 'Present' : $exp->end_year }}</span>
                                <div class="exp-info">
                                    <span class="title">{{ $exp->title }}</span>
                                    <span class="meta"><span class="company">{{ $exp->company }}</span> <span
                                            class="dot">•</span>
                                        <span class="location">{{ $exp->location }}</span></span>
                                </div>
                                <span class="desc">{{ $exp->description }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif


            <x-github-card :githubProjects="$githubProjects" />

        </div>


    </section>


</x-main-layout>
