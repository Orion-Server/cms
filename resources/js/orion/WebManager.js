import Alpine from 'alpinejs'
import Footer from '../components/Pages/Footer'
import Photos from '../components/Pages/Photos'
import TippyWrapper from '../external/TippyWrapper'
import NotyfWrapper from '../external/NotyfWrapper'
import SwiperWrapper from '../external/SwiperWrapper'
import DiscordWidget from '../components/DiscordWidget'
import OnlineFriends from '../components/OnlineFriends'
import Authentication from '../components/Authentication'
import ImageVisualizationWrapper from '../external/ImageVisualizationWrapper'
import TextareaEditor from '../components/Ui/TextareaEditor'
import Navigation from '../components/Navigation'
import AccountSettings from '../components/Pages/Users/AccountSettings'
import PasswordSettings from '../components/Pages/Users/PasswordSettings'
import IngameSettings from '../components/Pages/Users/IngameSettings'
import Staff from '../components/Pages/Staff'
import AutomaticSearch from '../components/Ui/AutomaticSearch'

export default class WebManager {
    static start() {
        // Alpine components
        WebManager.startAlpineComponents()

        // WebManager components
        WebManager.startTooltips()
        WebManager.listenAlerts()
        WebManager.startSliders()

        WebManager.detectHorizontallyScrollables()
        WebManager.startAlpineFlow()
    }

    static startAlpineComponents() {
        Photos.start()
        Footer.start()
        DiscordWidget.start()
        Authentication.start()
        ImageVisualizationWrapper.start()
        OnlineFriends.start()
        TextareaEditor.start()
        Navigation.start()
        Staff.start()
        AutomaticSearch.start()

        // User Settings
        AccountSettings.start()
        PasswordSettings.start()
        IngameSettings.start()
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
        document.addEventListener('turbolinks:load', () => {
            const scrollContainer = document.querySelectorAll(".scroll-x")

            Array.from(scrollContainer).map((container) => {
                container.addEventListener("wheel", (event) => {
                    event.preventDefault()
                    container.scrollLeft += event.deltaY * 1.96
                })
            })
        })
    }
}
