<x-main-layout :page="$page">
    <div style="max-width: 860px; margin: 2rem auto 5rem; padding: 0 1rem;">
        <div style="margin-bottom: 1.5rem;">
            <a href="{{ route('snippets.index') }}" class="back" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--muted); text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: color 0.15s ease;">
                &larr; Back to Code Snippets
            </a>
        </div>

        <article class="card" style="padding: clamp(1.5rem, 4vw, 2.5rem);">
            <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; margin-bottom: 16px;">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; padding: 4px 12px; border-radius: 6px; background: var(--accent-soft); color: var(--accent);">
                    {{ $snippet->category ?: $snippet->language }}
                </span>
                <span style="font-size: 0.85rem; color: var(--muted);">Published {{ $snippet->created_at->format('M d, Y') }}</span>
            </div>

            <h1 style="font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; margin-bottom: 1rem; color: var(--fg); line-height: 1.25;">
                {{ $snippet->title }}
            </h1>

            @if ($snippet->description)
                <p style="color: var(--muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 1.75rem;">
                    {{ $snippet->description }}
                </p>
            @endif

            <div style="position: relative; margin-top: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; background: #1e1e2e; padding: 10px 18px; border-radius: var(--radius) var(--radius) 0 0; border-bottom: 1px solid rgba(255,255,255,0.1);">
                    <span style="font-size: 0.75rem; font-family: monospace; color: #89b4fa; text-transform: uppercase; font-weight: 700;">
                        {{ $snippet->language ?: 'CODE' }}
                    </span>
                    <button type="button" onclick="copySnippetCode()" id="btnCopyCode" style="font-size: 0.75rem; background: rgba(255,255,255,0.1); color: #fff; border: none; padding: 6px 14px; border-radius: 6px; cursor: pointer; font-weight: 600; transition: background 0.2s;">
                        📋 Copy Code
                    </button>
                </div>
                <pre style="margin: 0; padding: clamp(1rem, 3vw, 1.5rem); background: #181825; color: #cdd6f4; border-radius: 0 0 var(--radius) var(--radius); overflow-x: auto; font-family: 'Fira Code', Consolas, Monaco, monospace; font-size: 0.875rem; line-height: 1.6;"><code id="snippetCode">{{ $snippet->code_content }}</code></pre>
            </div>
        </article>
    </div>

    <script>
        function copySnippetCode() {
            const codeText = document.getElementById('snippetCode').innerText;
            navigator.clipboard.writeText(codeText).then(() => {
                const btn = document.getElementById('btnCopyCode');
                btn.innerText = '✅ Copied!';
                setTimeout(() => {
                    btn.innerText = '📋 Copy Code';
                }, 2000);
            });
        }
    </script>
</x-main-layout>
