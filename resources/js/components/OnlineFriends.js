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

                let axiosResponseData = null;

                await axios.post(followUserEndpoint.replace(':userId', id))
                    .then(response => axiosResponseData = response.data)
                    .catch(error => {
                        axiosResponseData = error.response?.data

                        console.error('[FollowUser] - ', error)
                    })

                if(axiosResponseData) {
                    this.$dispatch('orion:alert', {
                        type: axiosResponseData?.type || 'error',
                        message: axiosResponseData?.message
                    })
                }

                setTimeout(() => this.delay = false, 2000)
            }
        }))
    }
}

export default new OnlineFriends
