import Alpine from 'alpinejs'

class WebPushNotifications {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('webPushNotifications', () => ({
            init() {
                if (!('serviceWorker' in navigator)) {
                    return
                }

                navigator.serviceWorker.register('assets/js/service-worker.js').then(() => {
                    this.initializePush()
                })
            },

            initializePush() {
                if (!('PushManager' in window)) {
                    return
                }

                if (Notification.permission === 'denied') {
                    return
                }

                if (Notification.permission === 'default') {
                    this.requestPermission()
                }

                this.subscribeUser()
            },

            requestPermission() {
                Notification.requestPermission().then((permission) => {
                    if (permission != 'granted') return;

                    this.subscribeUser()
                    console.log('subscribed')
                })
            },

            subscribeUser() {
                navigator.serviceWorker.ready.then((registration) => {
                    registration.pushManager.getSubscription().then((subscription) => {
                        console.log('test')
                        if (subscription) return
                        console.log('test2')

                        registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: this.urlBase64ToUint8Array('BHV7r1uCrP8auqueR2_Ca7XKsRfXMwXAeWH6TKI9F_bqvQI6gumJc4gxPES7bYiJ2LnKJ59Rb-Ti8WKO0K9a2zg')
                        }).then((subscription) => {
                            console.log('test3')
                            this.sendSubscriptionToServer(subscription)
                        })
                    })
                })
            },

            sendSubscriptionToServer(subscription) {
                console.log('test4')
                axios.post('/user/push-notifications/subscribe', {
                    endpoint: subscription.endpoint,
                    public_key: this._arrayBufferToBase64(subscription.getKey('p256dh')),
                    auth_token: this._arrayBufferToBase64(subscription.getKey('auth')),
                    content_encoding: 'aesgcm',
                })
            },

            urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4)
                const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/')

                const rawData = window.atob(base64)
                const outputArray = new Uint8Array(rawData.length)

                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i)
                }

                return outputArray
            }
        }))
    }
}

export default new WebPushNotifications
