import Alpine from 'alpinejs'
import TippyWrapper from '../external/TippyWrapper'
import NotyfWrapper from '../external/NotyfWrapper'
import Authentication from '../components/Authentication'
import Photos from '../components/Pages/Photos'

export default class WebManager {
    static start() {
        // Alpine components
        Authentication.start()
        Photos.start()

        // WebManager components
        WebManager.startTooltips()
        WebManager.listenAlerts()

        WebManager.startAlpineFlow()
    }

    static startTooltips() {
        TippyWrapper.start()
    }

    static listenAlerts() {
        window.addEventListener('orion:alert', event => {
            const { type, message, duration } = event.detail

            if(!type && !message) return

            NotyfWrapper.alert(type, message, duration)
        })
    }

    static startAlpineFlow() {
        window.Alpine = Alpine
        Alpine.start()
    }
}
