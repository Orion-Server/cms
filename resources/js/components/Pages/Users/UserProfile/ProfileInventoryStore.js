import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileInventory', {
        tabs: ['stickers', 'notes', 'widgets', 'backgrounds'],
        delay: false,
        currentTab: 'stickers',

        activeItem: null,
        placeQuantity: 1,

        async fetchUserItems() {
            const errorMessage = 'Failed to fetch inventory'
                    this.delay = true

            await this.profileComponent
                .fetchData(appUrl(`/api/profile/${this.profileComponent.username}/inventory`), ({ data }) => {
                    if(!data.success || !data.inventory) {
                        this.profileComponent.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    Object.entries(data.inventory).forEach(([tab, items]) => {

                    })
                }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        setProfileComponent(component) {
            this.profileComponent = component
        },

        openTab(tab) {
            if(!this.isValidTab(tab)) return

            this.resetHasNewTotalFromItemsByTab(this.currentTab)
            this.currentTab = tab

            this.resetSelectedItem()
            this.resetItemsCountForCurrentTab()
        },

        isValidTab(tab) {
            return this.tabs.includes(tab)
        },

        resetSelectedItem() {
            this.activeItem = null
            this.placeQuantity = 1
        }
    })
})

