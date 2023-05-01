import Alpine from 'alpinejs'

export default class Photos {
    static start() {
        document.addEventListener('alpine:init', () => Photos._startComponent())
    }

    static _startComponent() {
        Alpine.data('photosPage', () => ({
            loading: false,

            init() {
                this.$watch('loading', value => {
                    if(!value) return

                    this.$dispatch('orion:alert', { message: 'Not implemented yet', type: 'info' })
                    setTimeout(() => this.loading = false, 2000)
                })
            }
        }))
    }
}
