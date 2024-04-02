// Worker for web push notifications

self.addEventListener('push', (event) => {
    const data = event.data.json()

    event.waitUntil(
        self.registration.showNotification(data.title, {
            body: data.body,
            icon: data.icon
        })
    )
})

self.addEventListener('activated', async () => {
    const subscription = await self.registration.pushManager.getSubscription()

    if (!subscription) return

    const response = await fetch('/user/push-notifications/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            endpoint: subscription.endpoint,
            public_key: this._arrayBufferToBase64(subscription.getKey('p256dh')),
            auth_token: this._arrayBufferToBase64(subscription.getKey('auth')),
            content_encoding: 'aesgcm',
        })
    })

    if (!response.ok) {
        console.error('Failed to send subscription to server')
    }
})
