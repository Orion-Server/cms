import axios from 'axios'
import Alpine from 'alpinejs'

class IngameSettings {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('ingameSettings', (
            route,
            motto,
            receiveFriendRequests,
            allowFriendsFollow,
            allowRoomInvites,
            oldChat,
            blockCameraFollow
        ) => ({
            data: {
                motto,
                receiveFriendRequests,
                allowFriendsFollow,
                allowRoomInvites,
                oldChat,
                blockCameraFollow
            },
            loading: false,

            async submitForm() {
                if(this.loading) return

                this.loading = true

                await axios.post(route, this.data).then(response => {
                        const { type, message } = response.data

                        this.$dispatch('orion:alert', { type, message })
                    }).catch(error => {
                        const { message } = error.response.data

                        if(message && message.length) {
                            this.$dispatch('orion:alert', { type: 'error', message })
                        }

                        console.error('[IngameSettings] - ', error)
                    })

                setTimeout(() => this.loading = false, 2500)
            }
        }))
    }
}

export default new IngameSettings
