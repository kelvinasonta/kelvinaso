<x-main-layout :page="$page">
    <div style="max-width: 960px; margin: 2rem auto 5rem; padding: 0 1rem;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <p class="eyebrow">Developer Knowledge Base</p>
            <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 700; margin: 0.75rem 0 1rem;">Code Snippets & Architecture Notes</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                A collection of developer recipes, architectural patterns, and production-ready code utilities.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: 1.5rem;">
            @forelse ($snippets as $snip)
                <div style="background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s ease, border-color 0.2s ease;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                            <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 6px; background: var(--accent-soft); color: var(--accent);">
                                {{ $snip->category ?: $snip->language }}
                            </span>
                            <span style="font-size: 0.8rem; color: var(--muted);">{{ $snip->created_at->format('M d, Y') }}</span>
                        </div>
                        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 10px; color: var(--fg);">
                            <a href="{{ route('snippets.show', $snip->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $snip->title }}
                            </a>
                        </h2>
                        @if ($snip->description)
                            <p style="color: var(--muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px;">
                                {{ Str::limit($snip->description, 120) }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('snippets.show', $snip->slug) }}" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 0.9rem; color: var(--accent); text-decoration: none;">
                            View Code & Details &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--muted);">
                    <h3>No code snippets published yet.</h3>
                    <p>Check back soon for developer tips and code patterns!</p>
                </div>
            @endforelse
        </div>

        @if ($snippets->hasPages())
            <div style="margin-top: 36px; display: flex; justify-content: center;">
                {{ $snippets->links() }}
            </div>
        @endif
    </div>
</x-main-layout>
