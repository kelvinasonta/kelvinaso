<div id="preloader" class="preloader-overlay">
    <div class="preloader-content">
        <div class="preloader-spinner">
            <div class="preloader-ring"></div>
            <div class="preloader-dot"></div>
        </div>
        <div class="preloader-brand">
            <span class="preloader-text">{{ setting('site_name', 'Portfolio') }}</span>
        </div>
    </div>
</div>

<style>
.preloader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: var(--bg, #0b0c10);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.4s ease, visibility 0.4s ease;
}

.preloader-overlay.loaded {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.preloader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.25rem;
}

.preloader-spinner {
    position: relative;
    width: 52px;
    height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preloader-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 3px solid rgba(var(--accent-rgb, 240, 86, 58), 0.15);
    border-top-color: var(--accent, #f0563a);
    border-right-color: var(--accent-2, #db391c);
    border-radius: 50%;
    animation: preloaderSpin 0.85s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
}

.preloader-dot {
    width: 10px;
    height: 10px;
    background: var(--accent, #f0563a);
    border-radius: 50%;
    box-shadow: 0 0 15px var(--accent, #f0563a);
    animation: preloaderPulse 1.2s ease-in-out infinite alternate;
}

.preloader-brand {
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--muted, #888);
    opacity: 0.85;
}

@keyframes preloaderSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes preloaderPulse {
    0% { transform: scale(0.8); opacity: 0.5; }
    100% { transform: scale(1.25); opacity: 1; }
}

@media (prefers-reduced-motion: reduce) {
    .preloader-ring, .preloader-dot {
        animation: none;
    }
}
</style>

<script>
    (function() {
        const preloader = document.getElementById('preloader');
        if (!preloader) return;

        function hidePreloader() {
            if (!preloader.classList.contains('loaded')) {
                preloader.classList.add('loaded');
                setTimeout(() => {
                    if (preloader.parentNode) {
                        preloader.parentNode.removeChild(preloader);
                    }
                }, 500);
            }
        }

        if (document.readyState === 'complete') {
            hidePreloader();
        } else {
            window.addEventListener('load', hidePreloader);
            setTimeout(hidePreloader, 1200);
        }
    })();
</script>
