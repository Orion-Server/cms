import axios from 'axios'
import Alpine from 'alpinejs'
import interact from 'interactjs'
import XssWrapper from '../../../../../external/XssWrapper'
import Turbolinks from 'turbolinks'

document.addEventListener('alpine:init', () => {
    Alpine.store('profileItems', {
        activeItem: null,
        profileManager: null,

        themes: ['default', 'goldenframe', 'hcmachine', 'hcpillow', 'metal', 'note', 'notepad'],

        isBackgroundPreview: false,
        currentBackground: null,

        placedItems: [],
        removedItemIds: [],

        saveButtonDelay: false,

        showNoteEditingModal: false,
        activeNote: null,

        showChangeThemeDropdown: false,
        activeThemeableItem: null,

        init() {
            const alpineInstance = this

            interact('.home-draggable').draggable({
                allowFrom: '.drag-handle',
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

            const errorMessage = __('Failed to fetch placed items')

            await this.profileManager.fetchData(this.getPlacedItemsUrl(), ({ data }) => {
                if(!data.success || !data.items) {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                this.currentBackground = data.activeBackground
                this.placedItems = data.items
            }, errorMessage)

            this.profileManager.$nextTick(() => {
                this.detectNavigatableWidgets()
                this.profileManager.$dispatch('orion:home-loaded')
            })
        },

        getPlacedItemsUrl() {
            const urlParams = new URLSearchParams(window.location.search),
                badgesPage = urlParams.get('badges_page'),
                friendsPage = urlParams.get('friends_page')

            let baseUrl = appUrl(`/profile/${this.profileManager.username}/placed-items`)

            if(!badgesPage && !friendsPage) return baseUrl

            baseUrl += '?'

            if(badgesPage && badgesPage != '1') baseUrl += `&badges_page=${badgesPage}`
            if(friendsPage && friendsPage != '1') baseUrl += `&friends_page=${friendsPage}`

            return baseUrl
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
                this.placeBackground(item)
                return
            }

            if(item.home_item.type == 'w') {
                this.placeWidget(item)
                return
            }

            for (let i = 0; i < quantity; i++) {
                const id = item.item_ids.shift()

                if(!id) continue

                if(this.removedItemIds.includes(id)) {
                    this.placeRemovedItem(id)
                    continue
                }

                this.pushToPlacedItems(id, item)
            }
        },

        placeBackground(item) {
            item.id = item.item_ids.shift()

            this.backToInventory(this.currentBackground)
            this.currentBackground = item
        },

        async placeWidget(item) {
            const id = item.item_ids?.shift()

            if(!id) return

            let placedItem = null

            if(this.removedItemIds.includes(id)) {
                placedItem = this.placedItems.find(item => item.id == id)
            }

            const errorMessage = __('Failed to fetch widget')

            await this.profileManager.fetchData(appUrl(`/profile/${this.profileManager.username}/widget-content/${id}`), ({ data }) => {
                if(!data.success || !data.content) {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || errorMessage })
                    return
                }

                item.content = XssWrapper.clean(data.content)
                item.home_item.name = data.name
                item.widget_type = data.widget_type
            }, errorMessage)

            await this.pushToPlacedItems(id, item, placedItem)

            this.removedItemIds.splice(this.removedItemIds.indexOf(id), 1)

            this.profileManager.$nextTick(() => {
                this.detectNavigatableWidgets()
            })
        },

        async pushToPlacedItems(id, item, placedItem = null) {
            const itemData = placedItem || {
                id,
                home_item: item.home_item,
            }

            await this.setDefaultItemData(itemData)

            if(item.home_item.type == 'w') {
                itemData.content = item.content
                itemData.widget_type = item.widget_type
            }

            if(placedItem) return

            this.placedItems.push(itemData)
        },

        async placeRemovedItem(id) {
            const item = this.placedItems.find(item => item.id == id)

            if(!item) return

            await this.setDefaultItemData(item)

            this.removedItemIds.splice(this.removedItemIds.indexOf(id), 1)
        },

        setDefaultItemData(item) {
            return new Promise(resolve => {
                item.x = 0
                item.y = 0
                item.z = 0
                item.is_reversed = false
                item.hasChanges = true
                item.theme = this.getDefaultTheme(item)
                item.extra_data = ''
                item.parsed_data = ''

                this.profileManager.$nextTick(() => resolve())
            })
        },

        getDefaultTheme(item) {
            if(!item.home_item) return null

            if(item.home_item.type == 'n') return 'note'
            if(item.home_item.type == 'w') return 'default'

            return null
        },

        getPlacedItems() {
            return this.placedItems.filter(item => !this.removedItemIds.includes(item.id))
        },

        async backToInventory(item) {
            if(!item.home_item) return

            await this.profileManager.inventoryStore.backItemToInventory(item)

            this.removedItemIds.push(item.id)
        },

        editNote(item) {
            this.showNoteEditingModal = true
            this.activeNote = item

            this.profileManager.$dispatch('orion:note-value', {
                data: item.extra_data,
                parsedData: item.parsed_data,
            })
        },

        toggleThemeDropdown(item) {
            if(this.activeThemeableItem && this.activeThemeableItem.id == item.id) return this.closeThemeDropdown()

            this.showChangeThemeDropdown = true
            this.activeThemeableItem = item
        },

        closeThemeDropdown() {
            this.showChangeThemeDropdown = false
            this.activeThemeableItem = null
        },

        selectThemeForActiveThemeableItem(theme) {
            if(!this.themes.includes(theme)) return

            this.activeThemeableItem.theme = theme

            this.profileManager.$nextTick(() => this.closeThemeDropdown())
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
                        extra_data: item.extra_data || null,
                    }
                }).filter(item => item)

            this.saveButtonDelay = true

            await axios.post(appUrl(`/profile/${this.profileManager.username}/save`), { items, backgroundId: this.currentBackground?.id || 0 })
                .then(({ data }) => {
                    if(!data.success) {
                        this.profileManager.$dispatch('orion:alert', { type: 'error', message: data.message || __('Failed to save items') })
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

        saveNoteData(defaultData, parsedData) {
            if(!this.activeNote) return

            this.activeNote.hasChanges = true
            this.activeNote.extra_data = defaultData
            this.activeNote.parsed_data = parsedData

            this.showNoteEditingModal = false
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
        },

        detectNavigatableWidgets() {
            const pages = document.querySelectorAll('span[data-href]')

            if(!pages || !pages.length) return

            const onWidgetClick = (event) => {
                event.preventDefault()

                if(this.profileManager.editing) {
                    this.profileManager.$dispatch('orion:alert', {
                        type: 'info',
                        message: __('Navigation is blocked because you are editing your profile.')
                    })

                    return
                }

                Turbolinks.visit(event.target.dataset.href)
            }

            pages.forEach(page => {
                page.removeEventListener('click', onWidgetClick)
                page.addEventListener('click', onWidgetClick)
            })
        }
    })
})

