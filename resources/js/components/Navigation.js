import Alpine from 'alpinejs'

class Navigation {
    started = false

    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('navigation', (defaultTheme) => ({
            showMobileMenu: false,
            showSubmenuId: null,
            defaultTheme,
            theme: null,

            init() {
                if(!localStorage.theme) {
                    localStorage.setItem('theme', defaultTheme)
                }

                this.theme = localStorage.theme

                if(!this.theme || !['light', 'dark'].includes(this.defaultTheme)) {
                    this.theme = 'light'
                }

                this.setTheme()
            },

            setTheme() {
                if(this.theme == 'dark') document.documentElement.classList.add('dark')
                else document.documentElement.classList.remove('dark')
            },

            toggleTheme() {
                this.theme = this.theme == 'light' ? 'dark' : 'light'
                document.documentElement.classList.toggle('dark')

                localStorage.setItem('theme', this.theme)
            },

            isTheme(theme) {
                this.theme == theme
            },

            toggleMenu(id) {
                this.showSubmenuId = this.showSubmenuId == id ? null : id
            }
        }))
    }
}

export default new Navigation
