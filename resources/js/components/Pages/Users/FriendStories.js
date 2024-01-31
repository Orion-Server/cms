import Alpine from 'alpinejs'
import axios from 'axios'

class FriendStories {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('friendStories', (friendNames) => ({
            friendNames,
            currentStoryName: '',
            modalOpen: false,
            stories: [],
            storiesLoading: false,

            init() {
                console.log('start')
            },

            onStoryClick(friendName) {
                this.currentStoryName = friendName
                this.modalOpen = true
                this.storiesLoading = true
            }
        }))
    }
}

export default new FriendStories
