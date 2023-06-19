<div x-data="{
    modalOpen: false,

    init() {
        document.addEventListener('selectLanguageModal', ({ detail: value }) => {
            this.modalOpen = value
        })

        const blockLanguageModal = !! localStorage.getItem('blockLanguageModal')

        if(blockLanguageModal) return

        this.$nextTick(() => {
            this.modalOpen = !@json(Session::has('locale'))
        })
    },

    storeActionLocally() {
        this.modalOpen = false

        localStorage.setItem('blockLanguageModal', '1')
    }
}">
    <x-ui.modal
        title="{{ __('Select Language') }}"
        type="select-language"
    />
</div>
