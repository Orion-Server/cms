import axios from 'axios'
import Alpine from 'alpinejs'

class UserProfileComponent {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('userProfile', (
            inventoryEndpoint,
            shopCategoriesEndpoint,
            shopCategoryItemsByCategoryEndpoint,
            showCategoryItemsByTypeEndpoint,
        ) => ({
            endpoints: {
                inventoryEndpoint,
                shopCategoriesEndpoint,
                shopCategoryItemsByCategoryEndpoint,
                showCategoryItemsByTypeEndpoint
            },

            // Application data
            delay: false,
            editing: false,
            showBagModal: false,
            bagTab: 'inventory',

            // Shop data
            shopTab: 'home',
            shopCategories: [],
            showCategoriesElement: false,

            shopItems: new Map(),
            categoryTabId: null,
            categoryTabItems: [],

            activeShopItem: null,
            purchaseQuantity: 1,
            totalPrice: 0,

            // Inventory data
            inventory: new Map(),
            inventoryItem: null,
            inventoryTabItems: [],
            inventoryTab: 'stickers',

            init() {
                this.$watch('showBagModal', (value) => {
                    document.body.classList.toggle('overflow-hidden', value)
                })

                this.$watch('editing', async (value) => {
                    if(!value || this.delay) return

                    const errorMessage = 'Failed to fetch inventory'
                    this.delay = true

                    await this.fetchData(this.endpoints.inventoryEndpoint, ({ data }) => {
                        if(!data.success || !data.inventory) {
                            this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                            return
                        }

                        // TODO: Fix this
                        this.inventory = data.inventory
                    }, errorMessage)

                    setTimeout(() => this.delay = false, 1000)
                })

                this.$watch('purchaseQuantity', (value) => {
                    if(value < 1) this.purchaseQuantity = 1
                    else if(value > 100) this.purchaseQuantity = 100

                    this.purchaseQuantity = Math.floor(this.purchaseQuantity)

                    this.totalPrice = this.activeShopItem.price * this.purchaseQuantity
                })
            },

            currentBagTabIs(tab) {
                return this.bagTab === tab
            },

            currentShopTabIs(tab) {
                return this.shopTab === tab
            },

            openInventory() {
                this.bagTab = 'inventory'

                if(! this.isValidInventoryTab(this.inventoryTab)) {
                    this.inventoryTab = 'stickers'
                }

                this.showBagModal = true
                this.resetSelectedItem()
            },

            openInventoryTab(tab) {
                if(!this.isValidInventoryTab(tab)) return

                this.inventoryTab = tab
                this.resetSelectedItem()
            },

            isValidInventoryTab(tab) {
                return ['stickers', 'notes', 'widgets', 'backgrounds'].includes(tab)
            },

            openShop() {
                this.bagTab = 'shop'

                if(! this.isValidShopTab(this.shopTab)) {
                    this.shopTab = 'home'
                }

                this.showBagModal = true
                this.fetchShopCategories()
                this.resetSelectedItem()
            },

            openShopTab(tab) {
                if(!this.isValidShopTab(tab)) return

                this.shopTab = tab

                if(tab == 'categories') {
                    this.toggleShopCategoriesElement()
                } else {
                    this.showCategoriesElement = false
                    this.fetchItemsByType()
                    this.resetSelectedItem()
                }
            },

            isValidShopTab(tab) {
                return ['home', 'categories', 'notes', 'widgets', 'backgrounds'].includes(tab)
            },

            async fetchItemsByType() {
                if(this.shopTab == 'home') return

                const errorMessage = 'Failed to fetch shop items'
                this.delay = true

                this.fetchData(this.endpoints.showCategoryItemsByTypeEndpoint.replace('%TYPE%', this.shopTab), ({ data }) => {
                    if(!data.success || !data.items) {
                        this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    this.categoryTabItems = data.items
                    this.shopItems.set(this.shopTab, data.items)
                }, errorMessage)

                setTimeout(() => this.delay = false, 1000)
            },

            fetchShopCategories() {
                if(this.shopCategories.length) return

                const errorMessage = 'Failed to fetch shop categories'

                this.fetchData(this.endpoints.shopCategoriesEndpoint, ({ data }) => {
                    if(!data.success || !data.categories) {
                        this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    this.shopCategories = data.categories
                }, errorMessage)
            },

            toggleShopCategoriesElement() {
                this.showCategoriesElement = !this.showCategoriesElement
            },

            openCategoryTab(tabId) {
                if(!this.isValidCategoryTab(tabId)) return

                this.categoryTabId = tabId
                this.resetSelectedItem()

                if(this.shopItems.has(tabId)) this.categoryTabItems = this.shopItems.get(tabId)
                else this.fetchCategoryTab()
            },

            isValidCategoryTab(tab) {
                return this.shopCategories.map(category => category.id).includes(tab)
            },

            async fetchCategoryTab(tabId = null) {
                if(!tabId) tabId = this.categoryTabId

                if(!this.isValidCategoryTab(tabId)) return

                const errorMessage = 'Failed to fetch shop category'
                this.delay = true

                await this.fetchData(this.endpoints.shopCategoryItemsByCategoryEndpoint.replace('%ID%', tabId), ({ data }) => {
                    if(!data.success || !data.items) {
                        this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    this.categoryTabItems = data.items
                    this.shopItems.set(tabId, data.items)
                }, errorMessage)

                setTimeout(() => this.delay = false, 1000)
            },

            isShopHomepage() {
                return this.bagTab == 'shop' && this.currentShopTabIs('home')
            },

            selectItem(item) {
                this.activeShopItem = item
                this.purchaseQuantity = 1
                this.totalPrice = item.price
            },

            resetSelectedItem() {
                this.activeShopItem = null
                this.purchaseQuantity = 1
                this.totalPrice = 0
            },

            async fetchData(endpoint, onSuccessCallback, errorMessage = 'Failed to fetch data') {
                await axios.get(endpoint)
                    .then(response => onSuccessCallback(response))
                    .catch(data => {
                        this.$dispatch('orion:alert', { type: 'error', message: data?.message || errorMessage })

                        console.error('[UserProfile] Failed to fetch - ERROR: ', data)
                    })
            }
        }))
    }
}

export default new UserProfileComponent
