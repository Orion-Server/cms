import Alpine from 'alpinejs'

export default class ArticleReactions {
    static start() {
        document.addEventListener('alpine:init', () => ArticleReactions._startComponent())
    }

    static _startComponent() {
        Alpine.data('articleReactions', (endpointUrl) => ({
            endpointUrl: endpointUrl,
            delay: false,

            async addReaction(id) {
                if(!id || this.delay) return

                this.delay = true;

                await axios.post(endpointUrl.replace(':reactionId', id))
                    .then(({ data }) => {
                        if(data.success) {
                            this.$dispatch('orion:alert', { type: 'success', message: data.message })
                        }
                    })
                    .catch(error => console.error('[ArticleReactions] - ', error))

                setTimeout(() => this.delay = false, 2500)
            }
        }))
    }
}
