import Alpine from 'alpinejs'

class Notification {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('notification', () => ({
            opened: false,
            notifications: [],
            unreadNotificationsCount: 0,
            delay: 5000,
            lastFetchDelay: 0,
            loading: false,

            init() {
                this.fetchUnreadNotificationsCount()

                this.$watch('opened', async value => {
                    if(!value) return

                    await this.fetchNotifications()
                })
            },

            fetchUnreadNotificationsCount() {
                axios.post('/user/notifications/count')
                    .then(response => {
                        if(!response.data.success) return

                        this.unreadNotificationsCount = response.data.unread_count

                        if(this.unreadNotificationsCount > 0) {
                            document.title = `(${this.unreadNotificationsCount}) ${document.title}`
                        }
                    })
                    .catch(e => {
                        console.log('[Notification] - Error fetching unread notifications count', e)
                    })
            },

            async fetchNotifications() {
                if(Date.now() - this.lastFetchDelay < this.delay) return

                this.lastFetchDelay = Date.now()
                this.loading = true

                await axios.post('/user/notifications')
                    .then(response => {
                        if(!response.data.success) return

                        this.notifications = response.data.notifications
                        this.unreadNotificationsCount = 0

                        document.title = document.title.replace(/\([0-9]+\)/, '')
                    })
                    .catch(e => {
                        console.log('[Notification] - Error fetching notifications', e)
                    })

                this.loading = false
            }
        }))
    }
}

export default new Notification
