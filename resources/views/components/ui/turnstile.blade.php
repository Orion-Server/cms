<div class="cf-turnstile mt-4" data-sitekey="{{ config('hotel.turnstile.site_key') }}" data-callback="javascriptCallback"> </div>

@push('scripts')
	<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
	
@endpush