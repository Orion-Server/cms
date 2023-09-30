<script>
    window.appUrl = (completePath) => "{{ config('app.url') }}" + completePath;
    window.__ = (key) => {
        const translations = {
            'You have been registered successfully': "{{ __('You have been registered successfully') }}",
            'Please fill in all register fields': "{{ __('Please fill in all register fields') }}",
            'Please fill in all login fields': "{{ __('Please fill in all login fields') }}",
            'You have been logged in successfully.': "{{ __('You have been logged in successfully.') }}",
            'An error occurred while saving your profile.': "{{ __('An error occurred while saving your profile.') }}",
            'Failed to fetch inventory.': "{{ __('Failed to fetch inventory.') }}",
            'Failed to buy item.': "{{ __('Failed to buy item.') }}",
            'Failed to fetch data': "{{ __('Failed to fetch data') }}",
            'Failed to fetch placed items.': "{{ __('Failed to fetch placed items.') }}",
            'Failed to fetch shop category items.': "{{ __('Failed to fetch shop category items.') }}",
            'Failed to fetch shop categories.': "{{ __('Failed to fetch shop categories.') }}",
            'Failed to fetch shop items.': "{{ __('Failed to fetch shop items.') }}",
            'You have unsaved changes. Are you sure you want to leave?': "{{ __('You have unsaved changes. Are you sure you want to leave?') }}",
            'Are you sure you want to cancel editing?': "{{ __('Are you sure you want to cancel editing?') }}",
            'Navigation is blocked because you are editing your profile.': "{{ __('Navigation is blocked because you are editing your profile.') }}",
            'Failed to save items': "{{ __('Failed to save items') }}",
            'Failed to fetch widget': "{{ __('Failed to fetch widget') }}",
            'You must save your changes before sending a message.': "{{ __('You must save your changes before sending a message.') }}",
        }

        return translations[key] ?? key;
    }
</script>
