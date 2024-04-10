import Alpine from 'alpinejs'

class DiscordWidget {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('discordWidget', (widgetId) => ({
            discordData: null,
            loading: true,
            failed: false,

            init() {
                this.fetchDiscordData()
            },

            async fetchDiscordData() {
                await fetch(`https://discordapp.com/api/guilds/${widgetId}/widget.json`, {
                    method: 'GET',
                    mode: 'cors',
                    cache: 'reload'
                })
                .then(response => response.status == 200 ? response.json() : null)
                .then(jsonData => {
                    if(!jsonData) return this.failed = true

                    this.discordData = jsonData
                })
                .catch(error => {
                    this.failed = true
                    console.error('[DiscordWidget] - ', error)
                })

                setTimeout(() => this.loading = false, 1000)
            },

            getName() {
                return this.discordData?.name || 'Server not found'
            },

            getMembers() {
                return this.discordData.members
            },

            getOnlineUsersCount() {
                return this.discordData.presence_count
            },

            getInviteLink() {
                return this.discordData?.instant_invite
            },

            hasMembers() {
                return this.discordData?.members.length > 0
            },

            getMembers() {
                if(!this.hasMembers()) return []

                return this.discordData.members
            }
        }))
    }
}

export default new DiscordWidget
