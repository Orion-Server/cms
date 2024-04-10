import Alpine from 'alpinejs'

class Navigation {
    started = false

    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('navigation', () => ({
            showMobileMenu: false,
            showSubmenuId: null,

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
