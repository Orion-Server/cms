import Alpine from 'alpinejs'
import Photos from '../components/Pages/Photos'
import TippyWrapper from '../external/TippyWrapper'
import NotyfWrapper from '../external/NotyfWrapper'
import Authentication from '../components/Authentication'
import ImageVisualizationWrapper from '../external/ImageVisualizationWrapper'
import SwiperWrapper from '../external/SwiperWrapper'
import DiscordWidget from '../components/DiscordWidget'
import Footer from '../components/Footer'

export default class WebManager {
    static start() {
        // Alpine components
        Photos.start()
        Footer.start()
        DiscordWidget.start()
        Authentication.start()
        ImageVisualizationWrapper.start()

        // WebManager components
        WebManager.startTooltips()
        WebManager.listenAlerts()
        WebManager.startSliders()

        WebManager.detectHorizontallyScrollables()
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

    static startSliders() {
        SwiperWrapper.start()
    }

    static startAlpineFlow() {
        window.Alpine = Alpine
        Alpine.start()
    }

    static detectHorizontallyScrollables() {
        const scrollContainer = document.querySelectorAll(".scroll-x")

        Array.from(scrollContainer).map((container) => {
            container.addEventListener("wheel", (event) => {
                event.preventDefault()
                container.scrollLeft += event.deltaY * 1.96
            })
        })
    }
}
