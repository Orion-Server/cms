import axios from 'axios'
import Alpine from "alpinejs"

class ArticleReaction {
    start() {
        document.addEventListener("alpine:init", this._startComponent)
    }

    _startComponent() {
        Alpine.data("articleReaction", (endpoint) => ({
            endpoint,
            delay: false,

            toggleReaction(event) {
                if(this.delay) return

                const target = event.target,
                    type = target?.dataset?.type

                if(!target || !type) {
                    console.log('[ArticleReaction] - Target or type is not defined')
                    return
                }

                const latestScrollPosition = window.scrollY

                this.delay = true

                axios.post(this.endpoint, { type })
                    .then(response => {
                        const message = response.data?.message,
                            isSuccessful = response.data?.success

                        if(message) {
                            this.$dispatch('orion:alert', {
                                message,
                                type: isSuccessful ? 'success' : 'error'
                            })
                        }

                        if(!isSuccessful) return

                        setTimeout(Turbolinks.visit(response.data.href), 500)
                    })
                    .catch(error => {
                        if(error.response?.data?.message) {
                            this.$dispatch('orion:alert', {
                                message: error.response.data.message,
                                type: 'error'
                            })
                        }

                        console.log('[ArticleReaction] - ', error)
                    })

                setTimeout(() => this.delay = false, 1000)
            }
        }))
    }
}

export default new ArticleReaction()
