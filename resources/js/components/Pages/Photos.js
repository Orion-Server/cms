import axios from 'axios'
import Alpine from 'alpinejs'

class Photos {
    start() {
        document.addEventListener('alpine:init', this._startComponent)
    }

    _startComponent() {
        Alpine.data('photosPage', (photoLikeEndpoint) => ({
            delay: false,

            endpoints: {
                photoLikeEndpoint,
            },

            init() {
            },

            likePhoto(event, photoId) {
                if(this.delay) return

                this.delay = true

                const target = event.target,
                    toggleLikeClassNames = (firstAction, secondAction) => {
                        target.classList[firstAction]('fa-solid', 'text-blue-400')
                        target.classList[secondAction]('fa-regular', 'text-slate-200')
                    },
                    updatePhotoLikes = (likesCount) => {
                        if (!this.$refs[`photoLikes${photoId}`]) return

                        this.$refs[`photoLikes${photoId}`].textContent = likesCount
                    }

                updatePhotoLikes('...')

                axios.post(this.endpoints.photoLikeEndpoint.replace("%ID%", photoId))
                    .then(({ status, data }) => {
                        if(status != 200) return;

                        if(! data.status) {
                            toggleLikeClassNames('remove', 'add')
                        } else {
                            toggleLikeClassNames('add', 'remove')
                        }

                        updatePhotoLikes(data.likes)
                    })
                    .catch(error => console.error('[PhotosPage] - ', error))

                setTimeout(() => this.delay = false, 2500)
            }
        }))
    }
}

export default new Photos
