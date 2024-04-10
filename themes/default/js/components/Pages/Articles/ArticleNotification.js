import axios from 'axios'
import Alpine from "alpinejs"

class ArticleNotification {
    start() {
        document.addEventListener("alpine:init", this._startComponent)
    }

    _startComponent() {
        Alpine.data("articleNotification", (endpoint, isSubscriber) => ({
            endpoint,
            delay: false,
            isSubscriber,

            init() {
                this.$watch('isSubscriber', value => {
                    this.toggle()
                })
            },

            async toggle() {
                if(this.delay) return

                this.delay = true

                await axios.post(this.endpoint)
                    .then(response => {
                        const message = response.data?.message,
                            isSuccessful = response.data?.success

                        if(message) {
                            this.$dispatch('orion:alert', {
                                message,
                                type: isSuccessful ? 'success' : 'error'
                            })
                        }
                    })
                    .catch(error => {
                        if(error.response?.data?.message) {
                            this.$dispatch('orion:alert', {
                                message: error.response.data.message,
                                type: 'error'
                            })
                        }

                        console.log('[ArticleNotification] - ', error)
                    })

                setTimeout(() => this.delay = false, 1000)
            }
        }))
    }
}

export default new ArticleNotification()
