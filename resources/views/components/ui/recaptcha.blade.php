<div>
    <div class="g-recaptcha mt-4" data-sitekey="{{ config('hotel.recaptcha.site_key') }}"></div>
</div>

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
