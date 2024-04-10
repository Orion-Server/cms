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
            delay: 15000,
            lastFetchDelay: 0,
            loading: false,
            actionsDelay: false,

            init() {
                this.fetchUnreadNotificationsCount()

                setInterval(() => {
                    this.fetchUnreadNotificationsCount()
                }, this.getTimeInMinutes(1))

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
                            document.title = document.title.replace(/\([0-9]+\)/, '')
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
            },

            getAvatarFigure(figure, params) {
                const avatarFigure = figureUrl.replace('%FIGURE%', figure).replace('%PARAMS%', params)

                return `url('${avatarFigure}')`
            },

            getTimeInMinutes(minutes) {
                return minutes * 60 * 1000
            },

            async visitNotification(notification) {
                if(!notification.url || !notification.url?.length) return

                if(notification.state != 'read') {
                    await axios.post('/user/notifications/visit', { id: notification.id })
                }

                this.$nextTick(() => {
                    Turbolinks.visit(notification.url)
                })
            },

            async markAllAsRead() {
                if(this.actionsDelay) return

                this.actionsDelay = true

                await axios.post('/user/notifications/mark-all-as-read')
                    .then(response => {
                        if(!response.data.success) return

                        this.unreadNotificationsCount = 0

                        this.notifications.forEach(notification => {
                            notification.state = 'read'
                        })
                    })
                    .catch(e => {
                        console.log('[Notification] - Error marking all as read', e)
                    })

                setTimeout(() => this.actionsDelay = false, 1000)
            },

            async deleteAllNotifications() {
                if(this.actionsDelay) return

                this.actionsDelay = true

                await axios.post('/user/notifications/delete-all')
                    .then(response => {
                        if(!response.data.success) return

                        this.notifications = []
                    })
                    .catch(e => {
                        console.log('[Notification] - Error deleting all notifications', e)
                    })

                setTimeout(() => this.actionsDelay = false, 1000)
            }
        }))
    }
}

export default new Notification
