<div>
    <div
        class="cf-turnstile mt-4"
        data-sitekey="{{ config('hotel.turnstile.site_key') }}"
        data-callback="javascriptCallback"
        x-bind:data-theme="theme"
    ></div>
</div>

@push('scripts')
	<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
@endpush
