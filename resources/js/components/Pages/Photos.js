import Alpine from 'alpinejs'

class Photos {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
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

export default new Photos
