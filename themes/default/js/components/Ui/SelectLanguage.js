
export default new class SelectLanguage {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('selectLanguage', (needsOpenModalInitially) => ({
            modalOpen: false,

            init() {
                document.addEventListener('selectLanguageModal', ({ detail: value }) => {
                    this.modalOpen = value
                })

                const blockLanguageModal = !! localStorage.getItem('blockLanguageModal')

                if(blockLanguageModal) return

                this.$nextTick(() => {
                    this.modalOpen = needsOpenModalInitially
                })
            },

            storeActionLocally() {
                this.modalOpen = false

                localStorage.setItem('blockLanguageModal', '1')
            }
        }))
    }
}
