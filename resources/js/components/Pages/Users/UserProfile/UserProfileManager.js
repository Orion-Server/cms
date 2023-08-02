import axios from 'axios'
import Alpine from 'alpinejs'

import './store/ProfileShopStore'
import './store/ProfileItemsStore'
import './store/ProfileInventoryStore'

import './store/widgets/RatingStore'
import './store/widgets/GuestbookStore'

export default new class UserProfileManager {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfileManager', username => ({
            username,
            isOwner: document.getElementById('home-edit-bar'),

            editing: false,
            showBagModal: false,
            bagTab: 'inventory',

            init() {
                if(!this.isValidUsername()) return

                if(this.isOwner) {
                    this.shopStore.setProfileManager(this)
                    this.inventoryStore.setProfileManager(this)
                    this.treatPageReload()
                    this.initWatchers()
                }

                this.itemsStore.setProfileManager(this)
                this.ratingStore.setProfileManager(this)
                this.guestbookStore.setProfileManager(this)
            },

            treatPageReload() {
                window.onbeforeunload = () => {
                    if(!this.editing || ['dev', 'development', 'local'].includes(import.meta.env.MODE)) return

                    return __('You have unsaved changes. Are you sure you want to leave?')
                }
            },

            isValidUsername() {
                return this.username && this.username.length > 0
            },

            get shopStore() {
                return this.$store.profileShop
            },

            get inventoryStore() {
                return this.$store.profileInventory
            },

            get itemsStore() {
                return this.$store.profileItems
            },

            get ratingStore() {
                return this.$store.ratingWidget
            },

            get guestbookStore() {
                return this.$store.guestbookWidget
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

            onCancelPressed() {
                if (!window.confirm(__('Are you sure you want to cancel editing?'))) return

                this.editing = false
                location.reload()
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
                if(!this.isOwner) return

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
                    else if(value > this.inventoryStore.activeItem.item_ids.length) this.inventoryStore.placeQuantity = this.inventoryStore.activeItem.item_ids.length

                    if(this.inventoryStore.placeQuantity > 15) {
                        this.inventoryStore.placeQuantity = 15
                    }

                    this.inventoryStore.placeQuantity = Math.floor(this.inventoryStore.placeQuantity)
                })
            }
        }))
    }
}
