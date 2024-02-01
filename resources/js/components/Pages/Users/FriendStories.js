import Alpine from 'alpinejs'
import axios from 'axios'
import SwiperWrapper from '../../../external/SwiperWrapper'

class FriendStories {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('friendStories', (stories) => ({
            stories,
            currentStoryName: '',
            modalOpen: false,
            currentStories: [],

            init() {
                document.addEventListener('orion:next-story', () => {
                    if(!this.currentStoryName?.length) return;

                    const indexOf = Object.values(this.stories).findIndex((story, index) => Object.keys(this.stories)[index] === this.currentStoryName)

                    if(indexOf === -1) return;

                    const nextFriendStoryName = Object.keys(this.stories)[indexOf + 1]


                    if(!nextFriendStoryName) {
                        this.closeStory()
                        return;
                    }

                    this.$nextTick(() => {
                        this.onStoryClick(nextFriendStoryName)
                    })
                })
            },

            onStoryClick(friendName) {
                if(!this.stories[friendName]) return;

                this.currentStoryName = friendName
                this.modalOpen = true

                SwiperWrapper.createSwiper(
                    document.querySelector('.swiper#friendStory')
                );

                this.$nextTick(() => {
                    this.currentStories = Object.values(this.stories[friendName])
                })
            },

            closeStory() {
                this.modalOpen = false
                this.currentStoryName = ''
                this.currentStories = []

                document.dispatchEvent(new Event('orion:stop-story'))
            }
        }))
    }
}

export default new FriendStories
