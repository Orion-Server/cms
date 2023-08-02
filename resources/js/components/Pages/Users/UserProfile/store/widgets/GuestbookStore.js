import Alpine from 'alpinejs'
import axios from 'axios'
import Turbolinks from 'turbolinks'

document.addEventListener('alpine:init', () => {
    Alpine.store('guestbookWidget', {
        profileManager: null,
        delay: false,

        showModal: false,

        init() {
            document.addEventListener('orion:home-loaded', () => this.detectModalButtons())
        },

        detectModalButtons() {
            const openModalButton = document.querySelector('.guestbook-button-trigger'),
                sendMessageButton = document.querySelector('.send-message-button')

            if(openModalButton) {
                openModalButton.addEventListener('click', () => {
                    if(this.profileManager.editing) {
                        this.profileManager.$dispatch('orion:alert', { type: 'error', message: __('You must save your changes before sending a message.') })

                        return
                    }

                    this.showModal = true
                })
            }

            if(sendMessageButton) {
                sendMessageButton.addEventListener('click', () => {
                    if(this.profileManager.editing) {
                        this.profileManager.$dispatch('orion:alert', { type: 'error', message: __('You must save your changes before sending a message.') })

                        return
                    }

                    this.sendMessage()
                })
            }
        },

        setProfileManager(component) {
            this.profileManager = component
        },

        async sendMessage(message) {
            if(this.delay) return

            const input = document.getElementById('guestbook-message-input')

            if(!input || input.value?.length < 1) return

            this.delay = true

            await axios.post(appUrl(`/profile/${this.profileManager.username}/message`), { content: input.value })
                .then(({ data }) => {
                    if(!data.href) return

                    this.profileManager.$nextTick(() => {
                        Turbolinks.visit(data.href)

                        this.showModal = false
                        input.value = ''
                    })
                })
                .catch(data => {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: data?.response.data?.message || errorMessage })

                    console.error('[UserProfile] Failed to send a message - ERROR: ', data)
                })

            setTimeout(() => this.delay = false, 1000)
        }
    })
})

