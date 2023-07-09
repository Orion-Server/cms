import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileInventory', {
        tabs: ['stickers', 'notes', 'widgets', 'backgrounds'],
        delay: false,
        currentTab: 'stickers',

        allItems: {
            'stickers': [],
            'notes': [],
            'widgets': [],
            'backgrounds': []
        },

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

                    this.allItems = data.inventory
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
            this.activeItem = null
            this.placeQuantity = 1
        },

        selectItem(item) {
            if(this.activeItem && this.activeItem.home_item_id === item.home_item_id) return

            this.resetSelectedItem()

            this.activeItem = item
        },

        getItemsForCurrentTab() {
            return this.allItems[this.currentTab]
        },

        placeActiveItem(placeAllItems = false) {
            if(!this.activeItem) return

            this.placeQuantity = placeAllItems ? this.activeItem.item_ids.length : this.placeQuantity

            this.profileComponent.itemsStore.placeItem(this.activeItem, this.placeQuantity)

            this.resetSelectedItem()
            this.profileComponent.showBagModal = false
        },

        onPlacedItems() {
            if(!this.activeItem.item_ids?.length) {
                this.allItems[this.currentTab] = this.allItems[this.currentTab].filter(item => item.home_item_id !== this.activeItem.home_item_id)
            }

            this.resetSelectedItem()
        }
    })
})

