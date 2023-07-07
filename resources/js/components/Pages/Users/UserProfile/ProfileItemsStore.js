import Alpine from 'alpinejs'
import interact from 'interactjs'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileItems', {
        profileComponent: null,

        currentBackground: null,
        placedItems: [],

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
            await this.profileComponent.fetchData(this.profileComponent.homeEndpoints.placedItemsEndpoint, ({ data }) => {
                if(!data.success || !data.items) {
                    this.profileComponent.$dispatch('orion:alert', { type: 'error', message: data.message || 'Failed to fetch placed items' })
                    return
                }

                this.currentBackground = data.activeBackground
                this.placedItems = data.items
            }, 'Failed to fetch placed items')
        },

        selectItem(item) {
            this.activeItem = item
        },

        updateZIndex(item) {
            const highestZIndex = Math.max(...this.placedItems.map(item => item.z), 0)

            item.z = highestZIndex + 1
        },

        setProfileComponent(component) {
            this.profileComponent = component

            this.fetchPlacedItems()
        },

        placeItem(item, quantity) {
            if(!item.home_item) return

            for (let i = 0; i < quantity; i++) {
                this.placeItemOnce(item)
            }

            this.profileComponent.inventoryStore.discountItemQuantity(item, quantity)
        },

        placeItemOnce(item) {
            this.placedItems.push({
                home_item: {
                    image: item.home_item.image,
                    type: item.home_item.type,
                },
                x: item.x || 0,
                y: item.y || 0,
                z: item.z || 0,
                is_reversed: item.is_reversed || false,
                theme: item.theme || null,
            })
        },

        saveItems() {
            const items = this.placedItems.map(item => {
                return {
                    home_item_id: item.home_item.id,
                    x: item.x,
                    y: item.y,
                    z: item.z,
                    is_reversed: item.is_reversed,
                    theme: item.theme,
                }
            })

            this.profileComponent.postData(this.profileComponent.homeEndpoints.saveItemsEndpoint, { items }, ({ data }) => {
                if(!data.success) {
                    this.profileComponent.$dispatch('orion:alert', { type: 'error', message: data.message || 'Failed to save items' })
                    return
                }

                this.profileComponent.$dispatch('orion:alert', { type: 'success', message: data.message || 'Successfully saved items' })
            }, 'Failed to save items')
        }
    })
})

