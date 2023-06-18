<div x-data="{
    modalOpen: false,

    init() {
        this.modalOpen = !localStorage.getItem('language')

        document.addEventListener('toggle-language-modal', (event) => {
            console.log('chegou', event)
        })
    },

    setLanguage(language) {
        localStorage.setItem('language', language)
        this.modalOpen = false

        Turbolinks.visit(location.href, { action: 'replace' })
    }
}">
    <x-ui.modal
        title="Select Your Language"
        type="select-language"
    />

</div>
