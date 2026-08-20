@if (turnstileEnabled())
    <div class="mt-6 cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="light"></div>
    @once
        <script nonce="{{ request()->attributes->get('csp_nonce') }}" src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endonce
@endif

@error('captcha')
    <p class="mt-3 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
@enderror