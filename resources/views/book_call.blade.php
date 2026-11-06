<x-main-layout :page="$page">
    <div style="max-width: 900px; margin: 2rem auto 5rem; padding: 0 1rem;">
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <p class="eyebrow">Direct Calendar Booking</p>
            <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 700; margin: 0.75rem 0 1rem;">Schedule a Discovery Call</h1>
            <p style="color: var(--muted); font-size: 1.1rem; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                Select a convenient time slot for a 15-minute consultation, contract project inquiry, or technical advisory session.
            </p>
        </div>

        <div class="card" style="padding: clamp(1rem, 3vw, 1.5rem); min-height: 600px; overflow: hidden;">
            <iframe src="{{ $calendlyUrl }}" style="width: 100%; min-height: 650px; height: 75dvh; border: none; border-radius: var(--radius);" title="Schedule a Meeting" loading="lazy"></iframe>
        </div>
    </div>
</x-main-layout>
