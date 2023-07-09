import axios from 'axios'
import Alpine from 'alpinejs'
import interact from 'interactjs'
import Turbolinks from 'turbolinks'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileItems', {
        profileComponent: null,

        currentBackground: null,
        placedItems: [],

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
            await this.profileComponent.fetchData(appUrl(`/api/profile/${this.profileComponent.username}/placed-items`), ({ data }) => {
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

            if(!this.activeItem) return

            this.activeItem.hasChanges = true
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
            if(!item.item_ids?.length || !item.home_item) return

            for (let i = 0; i < quantity; i++) {
                const id = item.item_ids.shift()

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
                    }
                }).filter(item => item)

            this.saveButtonDelay = true

            await axios.post(appUrl(`/profile/${this.profileComponent.username}/save`), { items, backgroundId: this.currentBackground.id })
                .then(({ data }) => {
                    if(!data.success) {
                        this.profileComponent.$dispatch('orion:alert', { type: 'error', message: data.message || 'Failed to save items' })
                        return
                    }

                    this.profileComponent.$dispatch('orion:alert', { type: 'success', message: data.message })

                    setTimeout(() => {
                        Turbolinks.visit(data.href)

                        this.profileComponent.$nextTick(() => {
                            this.saveButtonDelay = false
                        })
                    }, 500)
                })
                .catch(data => {
                    this.$dispatch('orion:alert', { type: 'error', message: data?.message || 'Failed to save items' })
                    this.saveButtonDelay = false
                })
        }
    })
})

