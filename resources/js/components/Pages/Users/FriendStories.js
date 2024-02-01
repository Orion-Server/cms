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
            currentSwiperInstance: null,
            currentStory: null,

            init() {
                document.addEventListener('orion:next-story', () => {
                    if(!this.currentStoryName?.length) return;

                    const indexOf = Object.values(this.stories).findIndex(
                        (_, index) => Object.keys(this.stories)[index] === this.currentStoryName
                    )

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

                document.addEventListener('orion:current-story-slide', (event) => {
                    if(!this.currentStoryName?.length) return;

                    this.currentStory = this.currentStories[event.detail.currentIndex]
                })
            },

            onStoryClick(friendName) {
                if(!this.stories[friendName]) return;

                if(this.currentSwiperInstance) {
                    this.currentSwiperInstance.autoplay?.stop()
                    this.currentSwiperInstance.destroy(true, true)
                }

                this.currentStoryName = friendName
                this.modalOpen = true
                this.currentStory = null

                this.currentStories = []

                this.currentSwiperInstance = SwiperWrapper.createSwiper(
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
                this.currentStory = null
                this.currentSwiperInstance = null

                document.dispatchEvent(new Event('orion:stop-story'))
            },

            getActiveFriendBackground() {
                if(this.dataIsInvalid()) return '';

                return this.currentStory.avatar_background
            },

            getActiveFriendLook() {
                if(this.dataIsInvalid()) return '';

                return this.currentStory.look
            },

            getActiveFriendStoryTimestamp() {
                if(this.dataIsInvalid()) return '';

                return this.currentStory.timestamp
            },

            dataIsInvalid() {
                return !this.currentStoryName?.length || !this.currentStories.length || !this.currentStory
            }
        }))
    }
}

export default new FriendStories
