import axios from 'axios'
import Alpine from 'alpinejs'

export default class Client {
    static start() {
        document.addEventListener('alpine:init', Client._startComponent())
    }

    static _startComponent() {
        Alpine.data('client', (onlineCountEndpoint) => ({
            onlineCount: 0,
            showCmsFrame: false,
            onlineCountButtonDelay: false,

            endpoints: {
                onlineCount: onlineCountEndpoint
            },

            init() {
                this.$nextTick(() => {
                    this.reloadOnlineCount()

                    // 30 seconds interval to reload online count
                    setInterval(() => this.reloadOnlineCount(), this.getTime(30))
                })
            },

            toggleCms() {
                this.showCmsFrame = !this.showCmsFrame
            },

            async reloadOnlineCount() {
                if(this.onlineCountButtonDelay) return

                this.onlineCountButtonDelay = true
                this.onlineCount = '...'

                await axios.get(this.endpoints.onlineCount)
                    .then(response => {
                        if(!response.data) {
                            this.onlineCount = 'N/A'
                            return
                        }

                        this.onlineCount = response.data.onlineCount
                    })
                    .catch(error => console.error('[OnlineCount] - ', error))

                // 5 seconds delay to user reload online count manually
                setTimeout(() => this.onlineCountButtonDelay = false, this.getTime(5))
            },

            getTime(seconds) {
                return seconds * 1000
            }
        }))
    }
}
