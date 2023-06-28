import axios from 'axios'
import Alpine from 'alpinejs'

class UserProfileComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfile', () => ({
            editing: false,
            showBagModal: false,
            bagTab: 'inventory',

            openInventory() {
                this.bagTab = 'inventory'
                this.showBagModal = true
            },

            openShop() {
                this.bagTab = 'shop'
                this.showBagModal = true
            }
        }))
    }
}

export default new UserProfileComponent
