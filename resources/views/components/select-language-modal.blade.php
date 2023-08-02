<div x-data="selectLanguage(!@json(Session::has('locale')))">
    <x-ui.modal
        title="{{ __('Select Language') }}"
        type="select-language"
    />
</div>
