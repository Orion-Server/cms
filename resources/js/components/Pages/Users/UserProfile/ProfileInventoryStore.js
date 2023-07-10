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
            return this.allItems[this.currentTab].filter(item => !! item.item_ids?.length)
        },

        giveItemsForTab(tab, items) {
            if(tab == 'categories') tab = 'stickers'

            if(!this.isValidTab(tab)) return

            const firstItem = items[0]

            if(!firstItem) return

            if(!this.allItems[tab].length) {
                this.allItems[tab] = items
                return
            }

            const existingItem = this.allItems[tab].find(item => item.home_item_id === firstItem.home_item_id)

            if(!existingItem) {
                this.allItems[tab].push(...items)
                return
            }

            existingItem.item_ids.push(...firstItem.item_ids)
        },

        backItemToInventory(item) {
            let tab = ''

            if(item.home_item.type == 's') tab = 'stickers'
            else if(item.home_item.type == 'w') tab = 'widgets'
            else tab = 'notes'

            if(!this.isValidTab(tab)) return

            const existingItem = this.allItems[tab].find(tabItem => tabItem.home_item_id === item.home_item_id)

            if(!existingItem) {
                this.allItems[tab].push({
                    home_item_id: item.home_item.id,
                    item_ids: [item.id],
                    home_item: item.home_item
                })

                return
            }

            existingItem.item_ids.push(item.id)
        },

        placeActiveItem(placeAllItems = false) {
            if(!this.activeItem) return

            this.placeQuantity = placeAllItems ? this.activeItem.item_ids.length : this.placeQuantity

            this.profileComponent.itemsStore.placeItem(this.activeItem, this.placeQuantity)

            this.resetSelectedItem()
            this.profileComponent.showBagModal = false
        },
    })
})

