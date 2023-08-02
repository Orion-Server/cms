import Alpine from 'alpinejs'
import axios from 'axios'
import Turbolinks from 'turbolinks'

document.addEventListener('alpine:init', () => {
    Alpine.store('ratingWidget', {
        profileManager: null,
        delay: false,

        init() {
            document.addEventListener('orion:home-loaded', () => this.detectRatingStars())
        },

        detectRatingStars() {
            const ratingStars = document.querySelectorAll('.my-rating .stars span.star')

            if(!ratingStars) return

            ratingStars.forEach(ratingStar => {
                ratingStar.addEventListener('click', event => {
                    event.preventDefault()

                    this.rate(ratingStar?.dataset?.rating || 1)
                })
            })
        },

        setProfileManager(component) {
            this.profileManager = component
        },

        async rate(rating) {
            if(this.delay) return

            this.delay = true

            await axios.post(appUrl(`/profile/${this.profileManager.username}/rating`), { rating })
                .then(({ data }) => {
                    if(!data.href) return

                    this.profileManager.$nextTick(() => Turbolinks.visit(data.href))
                })
                .catch(data => {
                    this.profileManager.$dispatch('orion:alert', { type: 'error', message: data?.response.data?.message || errorMessage })

                    console.error('[UserProfile] Failed to evaluate home - ERROR: ', data)
                })

            setTimeout(() => this.delay = false, 1000)
        }
    })
})

