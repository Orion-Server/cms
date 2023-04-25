import TippyWrapper from '../external/TippyWrapper'
import NotyfWrapper from '../external/NotyfWrapper'

export default class WebManager {
    static start() {
        WebManager.startTooltips()
        WebManager.listenAlerts()
    }

    static startTooltips() {
        TippyWrapper.start()
    }

    static listenAlerts() {
        window.addEventListener('orion:alert', event => {
            const { type, message, duration } = event.detail

            if(!type || !message) return

            NotyfWrapper.alert(type, message, duration)
        })
    }
}
