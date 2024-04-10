import axios from 'axios'
import Alpine from 'alpinejs'
import Turbolinks from 'turbolinks'

class ChangeUsername {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('changeUsername', (route) => ({
            data: {
                newUsername: null,
                gender: 'M'
            },
            modalOpen: false,
            loading: false,

            async submitForm() {
                if(this.loading) return

                this.loading = true

                await axios.post(route, this.data).then(response => {
                        const { type, message } = response.data

                        this.$dispatch('orion:alert', { type, message })

                        setTimeout(() => Turbolinks.visit('/'), 1500)
                    }).catch(error => {
                        const { message } = error.response.data

                        if(message && message.length) {
                            this.$dispatch('orion:alert', { type: 'error', message })
                        }

                        console.error('[ChangeUsername] - ', error)
                    })

                setTimeout(() => this.loading = false, 2500)
            }
        }))
    }
}

export default new ChangeUsername
