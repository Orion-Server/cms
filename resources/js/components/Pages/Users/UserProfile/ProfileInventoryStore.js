import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileInventory', {
        tabs: ['stickers', 'notes', 'widgets', 'backgrounds'],
        delay: false,
        currentTab: 'stickers',

        allItems: new Map(),
        inventoryItem: null,
        inventoryTabItems: [],

        async fetchUserItems() {
            const errorMessage = 'Failed to fetch inventory'
                    this.delay = true

            await this.profileComponent
                .fetchData(this.profileComponent.inventoryEndpoints.itemsEndpoint, ({ data }) => {
                    if(!data.success || !data.inventory) {
                        this.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    Object.entries(data.inventory).forEach(([tab, items]) => {
                        this.allItems.set(tab, items)
                    })
                }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        setProfileComponent(component) {
            this.profileComponent = component
        },

        openTab(tab) {
            if(!this.isValidTab(tab)) return

            this.currentTab = tab
            this.resetSelectedItem()
        },

        isValidTab(tab) {
            return this.tabs.includes(tab)
        },

        resetSelectedItem() {
            // do something
        }
    })
})

