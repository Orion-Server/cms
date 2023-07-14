import Alpine from 'alpinejs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileInventory', {
        profileManager: null,
        tabs: ['stickers', 'notes', 'widgets', 'backgrounds'],
        delay: false,
        currentTab: 'stickers',
        loadingPlacedItem: false,

        allItems: {
            'stickers': [],
            'notes': [],
            'widgets': [],
            'backgrounds': []
        },

        activeItem: null,
        placeQuantity: 1,

        async fetchUserItems() {
            const errorMessage = __('Failed to fetch inventory.')
                    this.delay = true

            await this.profileManager
                .fetchData(appUrl(`/api/profile/${this.profileManager.username}/inventory`), ({ data }) => {
                    if(!data.success || !data.inventory) {
                        this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                        return
                    }

                    this.allItems = data.inventory
                }, errorMessage)

            setTimeout(() => this.delay = false, 1000)
        },

        setProfileManager(component) {
            this.profileManager = component
        },

        openTab(tab) {
            if(!this.isValidTab(tab)) return

            this.currentTab = tab

            this.resetSelectedItem()
        },

        isValidTab(tab) {
            return this.tabs.includes(tab)
        },

        canPlaceAllItems() {
            return this.activeItem?.item_ids.length > 1 && ['s'].includes(this.activeItem?.home_item?.type)
        },

        canPlaceMultipleItems() {
            return this.canPlaceAllItems()
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

        async backItemToInventory(item) {
            let tab = ''

            if(item.home_item.type == 's') tab = 'stickers'
            else if(item.home_item.type == 'w') tab = 'widgets'
            else if(item.home_item.type == 'b') tab = 'backgrounds'
            else tab = 'notes'

            if(!this.isValidTab(tab)) return

            await new Promise(resolve => {
                const existingItem = this.allItems[tab].find(tabItem => tabItem.home_item_id === item.home_item.id)

                if(existingItem) {
                    existingItem.item_ids.push(item.id)
                } else {
                    this.allItems[tab].push({
                        home_item_id: item.home_item.id,
                        item_ids: [item.id],
                        home_item: item.home_item
                    })
                }

                resolve()
            })
        },

        async placeActiveItem(placeAllItems = false) {
            if(!this.activeItem) return

            this.placeQuantity = placeAllItems ? this.activeItem.item_ids.length : this.placeQuantity

            if(this.activeItem.home_item.type == 'w') {
                this.loadingPlacedItem = true
                await this.profileManager.itemsStore.placeWidget(this.activeItem)

                this.loadingPlacedItem = false
            } else {
                this.profileManager.itemsStore.placeItem(this.activeItem, this.placeQuantity)
            }

            this.resetSelectedItem()
            this.profileManager.showBagModal = false
        },
    })
})

