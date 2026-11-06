<x-admin-layout :page="$page" :profile="$profile">

    <div class="page-header">
        <div>
            <h1>Create New Page</h1>
            <div class="sub">Add a new public static page to your portfolio.</div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('pages.admin') }}" class="btn secondary">Back to Pages</a>
        </div>
    </div>

    <div class="profile-grid">
        <form class="card" action="{{ route('pages.store.admin') }}" method="POST">
            @csrf

            <div style="display:flex;flex-direction:column;gap:18px;flex:2;">
                <div class="card-head">
                    <h3>Page Details</h3>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="form-grid cols-2">
                            <div class="field">
                                <label>Title <span style="color:#ef4444;">*</span></label>
                                <input class="input" name="title" value="{{ old('title') }}"
                                    placeholder="e.g. Services" required />
                                @error('title')
                                    <span style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="field">
                                <label>URL Path / Slug</label>
                                <input class="input" type="text" name="slug" value="{{ old('slug') }}"
                                    placeholder="e.g. services (auto-generated if empty)" />
                                @error('slug')
                                    <span style="color:#ef4444;font-size:0.8rem;margin-top:4px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <label>SEO Meta Description</label>
                            <textarea class="textarea" name="meta_description" rows="3" placeholder="Brief summary for search engine results">{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="field">
                            <label>Meta Keywords</label>
                            <textarea class="textarea" name="meta_keywords" rows="3" placeholder="comma, separated, keywords">{{ old('meta_keywords') }}</textarea>
                        </div>

                        <div class="form-grid cols-2">
                            <div class="field">
                                <label>Robots Directive</label>
                                <input class="input" name="robots" value="{{ old('robots', 'index, follow') }}" />
                            </div>
                            <div class="field">
                                <label>Status</label>
                                <select class="input" name="status">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Published
                                    </option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div style="display:flex;flex-direction:column;gap:18px;flex:1;">
                <div class="card">
                    <div class="card-head">
                        <h3>Actions</h3>
                    </div>
                    <div class="card-body">
                        <p class="muted" style="font-size:0.85rem;">After creating the page, you can configure
                            interactive sections on its detail page.</p>
                    </div>
                    <div class="card-head"
                        style="border-top:1px solid var(--c-border);border-bottom:none;display:flex;flex-direction:column;gap:10px;">
                        <button class="btn" type="submit" style="width:100%;justify-content:center;">Create
                            Page</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-admin-layout>
