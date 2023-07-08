import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileInventory', {
        tabs: ['stickers', 'notes', 'widgets', 'backgrounds'],
        delay: false,
        currentTab: 'stickers',

        allItems: {
            'stickers': {},
            'notes': {},
            'widgets': {},
            'backgrounds': {}
        },

        activeItem: null,
        placeQuantity: 1,

        newItemsCount: {
            stickers: 0,
            notes: 0,
            widgets: 0,
            backgrounds: 0
        },

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
                        items.forEach(item => {
                            if(!this.allItems[tab][item.home_item.id]) {
                                this.allItems[tab][item.home_item.id] = {
                                    total_items: 0,
                                    items: [item]
                                }
                            }

                            this.allItems[tab][item.home_item.id].total_items++
                            this.allItems[tab][item.home_item.id].items.push(item)
                        })
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

        giveItem(item, quantity, category) {
            if(category == 'categories') category = 'stickers'

            this.newItemsCount[category] += quantity

            if(!this.allItems.has(category)) {
                this.allItems.set(category, [])
            }

            const inventoryItem = this.allItems.get(category).find(i => i.home_item.id === item.id)

            if(inventoryItem) {
                inventoryItem.total_items += quantity
                inventoryItem.hasNewTotal = true
                return
            }

            this.allItems.get(category).push({
                home_item_id: item.id,
                total_items: quantity,
                hasNewTotal: true,
                home_item: { id: item.id, type: item.type, name: item.name, image: item.image }
            })
        },

        getItemsForCurrentTab() {
            return this.getItemsForTab(this.currentTab)
        },

        getItemsForTab(tab) {
            if(!this.isValidTab(tab)) return []

            return Object.entries(this.allItems[tab])
        },

        selectItem(item) {
            item.hasNewTotal = false
            this.placeQuantity = 1

            this.activeItem = item
        },

        placeSelectedItem(allItems = false) {
            this.profileComponent.itemsStore.placeItem(
                this.activeItem,
                allItems ? this.activeItem.total_items : this.placeQuantity
            )

            this.profileComponent.showBagModal = false
        },

        resetSelectedItem() {
            this.activeItem = null
            this.placeQuantity = 1
        },

        getNewItemsCountForTab(tab) {
            if(!this.isValidTab(tab)) return 0

            return this.newItemsCount[tab]
        },

        getNewItemsTotal() {
            return Object.values(this.newItemsCount).reduce((a, b) => a + b, 0)
        },

        discountItemQuantity(item, quantity) {
            if(!item) return

            item.total_items -= quantity

            if(item.total_items <= 0) {
                this.allItems.get(this.currentTab)
                    .splice(this.allItems.get(this.currentTab).indexOf(item), 1)

                this.activeItem = null
            }
        },

        resetItemsCountForCurrentTab() {
            this.newItemsCount[this.currentTab] = 0
        },

        resetHasNewTotalFromItemsByTab(tab) {
            if(!this.isValidTab(tab)) return

            this.getItemsForTab(tab).forEach(item => item.hasNewTotal = false)
        }
    })
})

