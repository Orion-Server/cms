import axios from 'axios'
import Alpine from 'alpinejs'
import interact from 'interactjs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileItems', {
        profileManager: null,

        isBackgroundPreview: false,
        currentBackground: null,
        placedItems: [],
        removedItemIds: [],

        saveButtonDelay: false,

        activeItem: null,

        init() {
            const alpineInstance = this

            interact('.home-draggable').draggable({
                modifiers: [
                    interact.modifiers.restrictRect({
                      restriction: '.home-container',
                      endOnly: true
                    })
                ],
                listeners: {
                    move (event) {
                        alpineInstance.activeItem.x += event.dx
                        alpineInstance.activeItem.y += event.dy
                    }
                }
            })
        },

        async fetchPlacedItems() {
            if(!this.profileManager.username?.length) return

            await this.profileManager.fetchData(appUrl(`/api/profile/${this.profileManager.username}/placed-items`), ({ data }) => {
                if(!data.success || !data.items) {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || 'Failed to fetch placed items' })
                    return
                }

                this.currentBackground = data.activeBackground
                this.placedItems = data.items
            }, 'Failed to fetch placed items')
        },

        selectItem(item) {
            if(!this.profileManager.editing) return

            this.activeItem = item

            if(!this.activeItem) return

            this.activeItem.hasChanges = true
        },

        updateZIndex(item) {
            if(!this.profileManager.editing) return

            const highestZIndex = Math.max(...this.placedItems.map(item => item.z), 0)

            item.z = highestZIndex + 1
        },

        setProfileManager(component) {
            this.profileManager = component

            this.fetchPlacedItems()
        },

        placeItem(item, quantity) {
            if(!item.item_ids?.length || !item.home_item) return

            if(item.home_item.type == 'b') {
                item.id = item.item_ids.shift()

                this.currentBackground = item
                return
            }

            for (let i = 0; i < quantity; i++) {
                const id = item.item_ids.shift()

                if(!id) continue

                if(this.removedItemIds.includes(id)) {
                    this.placeRemovedItem(id)
                    continue
                }

                this.placedItems.push({
                    id,
                    home_item: item.home_item,
                    x: 0,
                    y: 0,
                    z: 0,
                    is_reversed: false,
                    theme: null,
                })
            }
        },

        placeRemovedItem(id) {
            this.removedItemIds.splice(this.removedItemIds.indexOf(id), 1)

            const item = this.placedItems.find(item => item.id == id)

            if(!item) return

            item.x = 0
            item.y = 0
            item.z = 0
            item.is_reversed = false
            item.theme = null
        },

        getPlacedItems() {
            return this.placedItems.filter(item => !this.removedItemIds.includes(item.id))
        },

        async backToInventory(item) {
            if(!item.home_item || item.home_item.type == 'b') return

            await this.profileManager.inventoryStore.backItemToInventory(item)

            this.removedItemIds.push(item.id)
        },

        async saveItems() {
            if(this.saveButtonDelay) return

            const items = this.placedItems.map(item => {
                    if(!item.hasChanges) return null

                    return {
                        id: item.id,
                        x: item.x,
                        y: item.y,
                        z: item.z,
                        is_reversed: item.is_reversed,
                        theme: item.theme,
                        placed: !this.removedItemIds.includes(item.id),
                    }
                }).filter(item => item)

            this.saveButtonDelay = true

            await axios.post(appUrl(`/profile/${this.profileManager.username}/save`), { items, backgroundId: this.currentBackground?.id || 0 })
                .then(({ data }) => {
                    if(!data.success) {
                        this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || 'Failed to save items' })
                        return
                    }

                    this.profileManager.$dispatch('orion:alert', { type: 'success', message: data.message })

                    setTimeout(() => {
                        window.location.href = data.href
                    }, 1000)
                })
                .catch(data => {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: __('An error occurred while saving your profile.') })
                    this.saveButtonDelay = false
                })
        },

        previewBackground(background) {
            const oldBackground = this.currentBackground

            this.isBackgroundPreview = true
            this.currentBackground = background
            this.profileManager.showBagModal = false

            setTimeout(() => {
                this.isBackgroundPreview = false
                this.currentBackground = oldBackground
                this.profileManager.showBagModal = true
            }, 3000)
        },

        getBackground() {
            if(!this.isBackgroundPreview) {
                return this.currentBackground?.home_item?.image
            }

            return this.currentBackground.image
        }
    })
})

