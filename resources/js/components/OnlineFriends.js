import axios from 'axios'
import Alpine from 'alpinejs'

class OnlineFriends {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('onlineFriends', (followUserEndpoint) => ({
            delay: false,

            async followUser(id) {
                if(this.delay) return

                this.delay = true

                await axios.post(followUserEndpoint.replace(':userId', id))
                    .then(response => {
                        this.$dispatch('orion:alert', {
                            type: response.data.type,
                            message: response.data.message
                        })
                    })
                    .catch(error => {
                        console.error('[FollowUser] - ', error)
                    })

                setTimeout(() => this.delay = false, 2000)
            }
        }))
    }
}

export default new OnlineFriends
