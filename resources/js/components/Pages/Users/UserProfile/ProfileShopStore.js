import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileShop', {
        tabs: ['home', 'categories', 'notes', 'widgets', 'backgrounds'],
        currentTab: 'home',
        shopCategories: [],
        showCategoriesElement: false,
        delay: false,

        profileComponent: null,

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

            const errorMessage = 'Failed to fetch shop items'
            this.delay = true

            await this.profileComponent.fetchData(this.profileComponent.shopEndpoints.itemsByCategoryTypeEndpoint.replace('%TYPE%', this.currentTab), ({ data }) => {
                if(!data.success || !data.items) {
                    this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.categoryTabItems = data.items
                this.itemsByCategory.set(this.currentTab, data.items)
            }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        async fetchShopCategories() {
            if(this.shopCategories.length) return

            const errorMessage = 'Failed to fetch shop categories'

            await this.profileComponent.fetchData(this.profileComponent.shopEndpoints.categoriesEndpoint, ({ data }) => {
                if(!data.success || !data.categories) {
                    this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
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

            this.categoryTabId = tabId
            this.resetSelectedItem()

            if(this.itemsByCategory.has(tabId)) this.categoryTabItems = this.itemsByCategory.get(tabId)
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

            await this.profileComponent.fetchData(this.profileComponent.shopEndpoints.itemsByCategoryIdEndpoint.replace('%ID%', tabId), ({ data }) => {
                if(!data.success || !data.items) {
                    this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
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
            return this.profileComponent.bagTab == 'shop' && this.currentTab == 'home'
        },

        setProfileComponent(component) {
            this.profileComponent = component
        },
    })
})

