import Alpine from 'alpinejs'

export default class Footer {
    static start() {
        document.addEventListener('alpine:init', Footer._startComponent())
    }

    static _startComponent() {
        Alpine.data('footer', () => ({
            showScrollButton: false,

            init() {
                window.addEventListener('scroll', Alpine.debounce(() => {
                    this.showScrollButton = this.scrollIsGreaterThan(200)
                }, 500))
            },

            scrollIsGreaterThan(value) {
                return document.body.scrollTop > value || document.documentElement.scrollTop > value
            },

            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                })
            }
        }))
    }
}
