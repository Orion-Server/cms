import Alpine from 'alpinejs'
import Orion from '../components/Orion'
import Staff from '../components/Pages/Staff'
import Footer from '../components/Pages/Footer'
import Photos from '../components/Pages/Photos'
import Navigation from '../components/Navigation'
import TippyWrapper from '../external/TippyWrapper'
import NotyfWrapper from '../external/NotyfWrapper'
import SwiperWrapper from '../external/SwiperWrapper'
import DiscordWidget from '../components/DiscordWidget'
import OnlineFriends from '../components/OnlineFriends'
import Authentication from '../components/Authentication'
import SelectLanguage from '../components/Ui/SelectLanguage'
import TextareaEditor from '../components/Ui/TextareaEditor'
import AutomaticSearch from '../components/Ui/AutomaticSearch'
import AlpineHelpers from '../components/Helpers/AlpineHelpers'
import ShopComponent from '../components/Pages/Shop/ShopComponent'
import FriendStories from '../components/Pages/Users/FriendStories'
import IngameSettings from '../components/Pages/Users/IngameSettings'
import ChangeUsername from '../components/Pages/Users/ChangeUsername'
import AccountSettings from '../components/Pages/Users/AccountSettings'
import PasswordSettings from '../components/Pages/Users/PasswordSettings'
import ArticleReaction from '../components/Pages/Articles/ArticleReaction'
import ImageVisualizationWrapper from '../external/ImageVisualizationWrapper'
import UserProfileManager from '../components/Pages/Users/UserProfile/UserProfileManager'

export default class WebManager {
    static start() {
        // Alpine components
        WebManager.startAlpineComponents()

        // WebManager components
        WebManager.startTooltips()
        WebManager.listenAlerts()
        WebManager.startSliders()

        WebManager.detectHorizontallyScrollables()
        WebManager.detectCaptchasAfterNavigation()
        WebManager.startAlpineFlow()
    }

    static startAlpineComponents() {
        AlpineHelpers.start()

        Photos.start()
        Footer.start()
        DiscordWidget.start()
        Authentication.start()
        ImageVisualizationWrapper.start()
        OnlineFriends.start()
        TextareaEditor.start()
        Orion.start()
        Navigation.start()
        Staff.start()
        AutomaticSearch.start()
        ArticleReaction.start()
        SelectLanguage.start()

        // User Components
        AccountSettings.start()
        PasswordSettings.start()
        ChangeUsername.start()
        IngameSettings.start()
        FriendStories.start()

        // Shop Components
        ShopComponent.start()

        UserProfileManager.start()
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

        window.notyf = NotyfWrapper
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
                    container.scrollLeft += event.deltaY * (Math.PI / 2)
                })
            })
        })
    }

    static detectCaptchasAfterNavigation() {
        let isFirstLoad = true

        document.addEventListener('turbolinks:load', () => {
            if(isFirstLoad) {
                isFirstLoad = false
                return
            }

            const turnstileContainers = document.querySelectorAll(".cf-turnstile"),
                recaptchaContainers = document.querySelectorAll(".g-recaptcha")

            Array.from(turnstileContainers).map((container) => {
                if(!turnstile || !turnstile.render) return console.error('[Turnstile] is not defined')

                if(!container.dataset.sitekey) return console.error('[Recaptcha sitekey] is not defined')

                turnstile.render(container, {
                    sitekey: container.dataset.sitekey
                })
            })

            Array.from(recaptchaContainers).map((container) => {
                if(!grecaptcha || !grecaptcha.render) return console.error('[Recaptcha] is not defined')

                if(!container.dataset.sitekey) return console.error('[Recaptcha sitekey] is not defined')

                grecaptcha.render(container, {
                    sitekey: container.dataset.sitekey
                })
            })
        })
    }
}
