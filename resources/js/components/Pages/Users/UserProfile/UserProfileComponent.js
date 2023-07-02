import axios from 'axios'
import Alpine from 'alpinejs'

class UserProfileComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfile', (inventoryEndpoint) => ({
            endpoints: {
                inventoryEndpoint,
            },

            delay: false, // Prevents double click
            editing: false,
            showBagModal: false,
            bagTab: 'inventory',

            shop: [],
            shopTab: 'home',
            showCategoriesElement: false,

            inventory: [],
            inventoryTab: 'stickers',

            init() {
                this.$watch('showBagModal', (value) => {
                    document.body.classList.toggle('overflow-hidden', value)
                })

                this.$watch('editing', (value) => {
                    if(!value || this.delay) return

                    this.delay = true

                    axios.get(this.endpoints.inventoryEndpoint)
                        .then(({ data }) => {
                            if(!data.success || !data.inventory) {
                                this.$dispatch('orion:alert', { type: 'error', message: data.message })
                                return
                            }

                            this.inventory = data.inventory
                        })
                        .catch(data => {
                            this.$dispatch('orion:alert', { type: 'error', message: data?.message || 'Failed to fetch inventory' })

                            console.error('[UserProfileComponent] Failed to fetch inventory - ERROR: ', data)
                        })

                    setTimeout(() => this.delay = false, 2500)
                })
            },

            currentBagTabIs(tab) {
                return this.bagTab === tab
            },

            openInventory() {
                this.bagTab = 'inventory'

                if(! this.isValidInventoryTab(this.inventoryTab)) {
                    this.inventoryTab = 'stickers'
                }

                this.showBagModal = true
            },

            openShop() {
                this.bagTab = 'shop'

                if(! this.isValidShopTab(this.shopTab)) {
                    this.shopTab = 'home'
                }

                this.showBagModal = true
            },

            openInventoryTab(tab) {
                if(!this.isValidInventoryTab(tab)) return

                this.inventoryTab = tab
            },

            openShopTab(tab) {
                if(!this.isValidShopTab(tab)) return

                this.shopTab = tab

                if(tab == 'categories') this.toggleShopCategoriesElement()
            },

            isValidInventoryTab(tab) {
                return ['stickers', 'notes', 'widgets', 'backgrounds'].includes(tab)
            },

            isValidShopTab(tab) {
                return ['home', 'categories', 'notes', 'widgets', 'backgrounds'].includes(tab)
            },

            toggleShopCategoriesElement() {
                this.showCategoriesElement = !this.showCategoriesElement
            }
        }))
    }
}

export default new UserProfileComponent
