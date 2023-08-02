import Alpine from 'alpinejs'
import axios from 'axios'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileShop', {
        tabs: ['home', 'categories', 'notes', 'widgets', 'backgrounds'],
        currentTab: 'home',
        shopCategories: [],
        showCategoriesElement: false,
        delay: false,
        buttonDelay: false,

        profileManager: null,

        itemsByCategory: new Map(),
        categoryTabId: null,
        categoryTabItems: [],

        activeItem: null,
        purchaseQuantity: 1,
        totalPrice: 0,

        openTab(tab) {
            if(!this.isValidTab(tab)) return

            this.currentTab = tab

            if(tab == 'categories') {
                this.toggleCategoriesElement()
                return
            }

            this.showCategoriesElement = false
            this.fetchItemsByType()
            this.resetSelectedItem()
        },

        isValidTab(tab) {
            return this.tabs.includes(tab)
        },

        async fetchItemsByType() {
            if(this.currentTab == 'home' || !this.isValidTab(this.currentTab)) return

            if(this.itemsByCategory.has(this.currentTab)) {
                this.categoryTabItems = this.itemsByCategory.get(this.currentTab)
                return
            }

            const errorMessage = __('Failed to fetch shop items.')
            this.delay = true

            await this.profileManager.fetchData(appUrl(`/api/profile/shop/type/${this.currentTab}/items`), ({ data }) => {
                if(!data.success || !data.items) {
                    this.dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.categoryTabItems = data.items
                this.itemsByCategory.set(this.currentTab, data.items)
            }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        async fetchShopCategories() {
            if(this.shopCategories.length) return

            const errorMessage = __('Failed to fetch shop categories.')

            await this.profileManager.fetchData(appUrl(`/api/profile/shop/categories`), ({ data }) => {
                if(!data.success || !data.categories) {
                    this.dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.shopCategories = data.categories
            }, errorMessage)
        },

        toggleCategoriesElement() {
            this.showCategoriesElement = !this.showCategoriesElement
        },

        openCategoryTab(tabId) {
            if(!this.isValidCategoryTab(tabId)) return

            this.resetSelectedItem()
            this.categoryTabId = tabId

            if(this.itemsByCategory.has(tabId)) this.categoryTabItems = this.itemsByCategory.get(tabId)
            else this.fetchCategoryTab()
        },

        isValidCategoryTab(tab) {
            return this.shopCategories.map(category => category.id).includes(tab)
        },

        async fetchCategoryTab(tabId = null) {
            if(!tabId) tabId = this.categoryTabId

            if(!this.isValidCategoryTab(tabId)) return

            const errorMessage = __('Failed to fetch shop category items.')
            this.delay = true

            await this.profileManager.fetchData(appUrl(`/api/profile/shop/category/${tabId}/items`), ({ data }) => {
                if(!data.success || !data.items) {
                    this.dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.categoryTabItems = data.items
                this.itemsByCategory.set(tabId, data.items)
            }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        resetSelectedItem() {
            this.activeItem = null
            this.purchaseQuantity = 1
            this.totalPrice = 0
        },

        selectItem(item) {
            this.activeItem = item
            this.purchaseQuantity = 1
            this.totalPrice = item.price
        },

        isHomepage() {
            return this.profileManager.bagTab == 'shop' && this.currentTab == 'home'
        },

        setProfileManager(component) {
            this.profileManager = component
        },

        getCurrencyIcon(item = null) {
            if(!item) item = this.activeItem

            if(!item) return ''

            switch(item.currency_type) {
                case -1:
                default:
                    return 'https://i.imgur.com/dijttdM.png'
                case 0:
                    return 'https://imgur.com/Yf8pbjY.png'
                case 5:
                    return 'https://imgur.com/5HOWcZS.png'
                case 101:
                    return 'https://imgur.com/93gYnPp.png'
            }
        },

        async buyItem() {
            if(this.buttonDelay || !this.activeItem) return

            let errorMessage = __('Failed to buy item.')
            this.buttonDelay = true

            await axios.post(appUrl(`/profile/${this.profileManager.username}/buy-item`), {
                item_id: this.activeItem.id,
                quantity: this.purchaseQuantity
            }).then(({ data }) => {
                if(!data.success || !data.items || !data.items.length) {
                    this.dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.dispatch('orion:alert', { type: 'success', message: data.message })

                this.profileManager.inventoryStore.giveItemsForTab(this.currentTab, data.items)
            }).catch(error => {
                errorMessage = error.response?.data?.message || errorMessage

                this.dispatch('orion:alert', { type: 'error', message: errorMessage })
            })

            setTimeout(() => this.buttonDelay = false, 1000)
        },

        previewBackground(background = null) {
            if(!background) background = this.activeItem

            this.profileManager.itemsStore.previewBackground(background)
        },

        dispatch(event, data) {
            this.profileManager.$dispatch(event, data)
        }
    })
})

