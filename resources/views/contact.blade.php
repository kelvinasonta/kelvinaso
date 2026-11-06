<x-main-layout :page="$page">

    <main class="container" style="max-width:960px;">
        <div class="page-head">
            <p class="eyebrow">Contact · Available for new projects</p>
            <h1>Need to ask any <span class="text-gradient">questions?</span></h1>
        </div>

        <div class="contact-tiles" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap:1.5rem; margin-top:1.5rem;">
            <a href="mailto:{{ $email ?? '' }}" class="card" style="padding: clamp(1.5rem, 4vw, 2rem);">
                <p class="eyebrow" style="color:var(--muted);">Email</p>
                <p style="font-size: clamp(1.2rem, 3vw, 1.6rem); font-weight:600; margin-top:0.75rem; word-break: break-all;">{{ $email ?? '' }} →</p>
            </a>
            <a href="tel:{{ $phone ?? '' }}" class="card" style="padding: clamp(1.5rem, 4vw, 2rem);">
                <p class="eyebrow" style="color:var(--muted);">Schedule a call</p>
                <p style="font-size: clamp(1.2rem, 3vw, 1.6rem); font-weight:600; margin-top:0.75rem;">Let's Talk →</p>
            </a>
        </div>

        <form id="contact-form" class="card form" novalidate style="margin-top:2.5rem;">
            <div>
                <p class="eyebrow">Or send a brief</p>
                <h2 style="margin-top:0.5rem;">Tell me about your project</h2>
            </div>
            <div class="form-grid">
                <div class="field" data-field="name">
                    <label class="field-label" for="f-name">Name</label>
                    <input class="input" id="f-name" name="name" type="text" autocomplete="name"
                        maxlength="100" placeholder="Jane Doe" />
                    <span class="field-error"></span>
                </div>
                <div class="field" data-field="email">
                    <label class="field-label" for="f-email">Email</label>
                    <input class="input" id="f-email" name="email" type="email" autocomplete="email"
                        maxlength="255" placeholder="jane@company.com" />
                    <span class="field-error"></span>
                </div>
            </div>
            <div class="field" data-field="subject">
                <label class="field-label" for="f-subject">Subject</label>
                <input class="input" id="f-subject" name="subject" type="text" maxlength="150"
                    placeholder="Laravel backend for a fintech ledger" />
                <span class="field-error"></span>
            </div>
            <div class="field" data-field="message">
                <label class="field-label" for="f-message">Message</label>
                <textarea class="textarea" id="f-message" name="message" maxlength="2000"
                    placeholder="A few lines on what you're building, timeline and budget."></textarea>
                <span class="field-error"></span>
            </div>
            <div class="form-footer">
                <p class="form-note">I read every message. Avg reply &lt; 48h.</p>
                <button type="submit" class="btn btn-primary">Send message</button>
            </div>
        </form>
    </main>

</x-main-layout>
