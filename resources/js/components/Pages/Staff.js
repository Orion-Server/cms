import Alpine from 'alpinejs'

class Staff {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('staff', () => ({
            activeTab: 0,

            changeTab({ target }, tab) {
                if(tab === this.activeTab) return

                this.activeAllButtons()
                this.activeTab = tab

                target.setAttribute('disabled', true)
            },

            activeAllButtons() {
                const buttons = document.querySelectorAll('button#staff-tab-button')

                buttons.forEach(button => button.removeAttribute('disabled'))
            },

            isTab(tab) {
                return this.activeTab == '0' || this.activeTab === tab
            }
        }))
    }
}

export default new Staff
