<div x-data="{
    modalOpen: false,

    init() {
        this.$nextTick(() => {
            this.modalOpen = !@json(Session::has('locale'))
        })

        document.addEventListener('selectLanguageModal', ({ detail: value }) => {
            this.modalOpen = value
        })
    }
}">
    <x-ui.modal
        title="Select Language"
        type="select-language"
    />
</div>
