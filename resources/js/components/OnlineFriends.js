import axios from 'axios'
import Alpine from 'alpinejs'

export default class OnlineFriends {
    static start() {
        document.addEventListener('alpine:init', OnlineFriends._startComponent())
    }

    static _startComponent() {
        Alpine.data('onlineFriends', (followUserEndpoint) => ({
            delay: false,

            async followUser(id) {
                if(this.delay) return

                this.delay = true

                await axios.post(followUserEndpoint.replace(':userId', id))
                    .then(response => {
                        OnlineFriends._dispatchErrorFromAxios(this, response.data)
                    })
                    .catch(error => {
                        console.error('[FollowUser] - ', error)
                    })

                setTimeout(() => this.delay = false, 2000)
            }
        }))
    }

    static _dispatchErrorFromAxios(componentInstance, data) {
        componentInstance.$dispatch('orion:alert', {
            type: data.type,
            message: data.message
        })
    }
}
