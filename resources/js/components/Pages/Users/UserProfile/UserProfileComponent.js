import axios from 'axios'
import Alpine from 'alpinejs'
import './ProfileShopStore'
import './ProfileInventoryStore'

class UserProfileComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfile', (itemsEndpoint, categoriesEndpoint, itemsByCategoryIdEndpoint, itemsByCategoryTypeEndpoint, buyItemEndpoint) => ({
            inventoryEndpoints: {
                itemsEndpoint,
            },

            shopEndpoints: {
                categoriesEndpoint,
                itemsByCategoryIdEndpoint,
                itemsByCategoryTypeEndpoint,
                buyItemEndpoint
            },

            editing: false,
            showBagModal: false,
            bagTab: 'inventory',

            init() {
                this.shopStore.setProfileComponent(this)
                this.inventoryStore.setProfileComponent(this)

                this.initWatchers()
            },

            get shopStore() {
                return this.$store.profileShop
            },

            get inventoryStore() {
                return this.$store.profileInventory
            },

            currentBagTabIs(tab) {
                return this.bagTab === tab
            },

            currentShopTabIs(tab) {
                return this.shopStore.currentTab === tab
            },

            currentInventoryTabIs(tab) {
                return this.inventoryStore.currentTab === tab
            },

            openInventory() {
                this.bagTab = 'inventory'

                if(! this.inventoryStore.isValidTab(this.inventoryStore.currentTab)) {
                    this.inventoryStore.openTab('stickers')
                }

                this.showBagModal = true
                this.resetSelectedItem()
                this.inventoryStore.resetItemsCountForCurrentTab()
            },

            openShop() {
                this.bagTab = 'shop'

                if(! this.shopStore.isValidTab(this.shopStore.currentTab)) {
                    this.shopStore.openTab('home')
                }

                this.showBagModal = true
                this.shopStore.fetchShopCategories()
                this.resetSelectedItem()
            },

            resetSelectedItem() {
                this.shopStore.resetSelectedItem()
                this.inventoryStore.resetSelectedItem()
            },

            async fetchData(endpoint, onSuccessCallback, errorMessage = 'Failed to fetch data') {
                await axios.get(endpoint)
                    .then(response => onSuccessCallback(response))
                    .catch(data => {
                        this.$dispatch('orion:alert', { type: 'error', message: data?.message || errorMessage })

                        console.error('[UserProfile] Failed to fetch - ERROR: ', data)
                    })
            },

            initWatchers() {
                this.$watch('showBagModal', (value) => document.body.classList.toggle('overflow-hidden', value))

                this.$watch('editing', async (value) => {
                    if(!value || this.inventoryStore.delay) return

                    await this.inventoryStore.fetchUserItems()
                })

                this.$watch(() => this.shopStore.purchaseQuantity, (value) => {
                    if(!this.shopStore.activeItem) return

                    if(value < 1) this.shopStore.purchaseQuantity = 1
                    else if(value > 100) this.shopStore.purchaseQuantity = 100

                    this.shopStore.purchaseQuantity = Math.floor(this.shopStore.purchaseQuantity)
                    this.shopStore.totalPrice = this.shopStore.activeItem.price * this.shopStore.purchaseQuantity
                })

                this.$watch(() => this.inventoryStore.placeQuantity, (value) => {
                    if(!this.inventoryStore.activeItem) return

                    if(value < 1) this.inventoryStore.placeQuantity = 1
                    else if(value > this.inventoryStore.activeItem.total_items) this.inventoryStore.placeQuantity = this.inventoryStore.activeItem.total_items

                    if(this.inventoryStore.placeQuantity > 15) {
                        this.inventoryStore.placeQuantity = 15
                    }

                    this.inventoryStore.placeQuantity = Math.floor(this.inventoryStore.placeQuantity)
                })
            }
        }))
    }
}

export default new UserProfileComponent
