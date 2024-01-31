export default class SwiperWrapper {
    static start() {
        document.addEventListener('turbolinks:load', () => {
            SwiperWrapper.detectSwiperContainers()
        })
    }

    static detectSwiperContainers() {
        const swiperContainers = document.querySelectorAll('.swiper')

        Array.from(swiperContainers).forEach(swiperContainer => {
            SwiperWrapper.createSwiper(swiperContainer)
        })
    }

    static createSwiper(swiperContainer) {
        const elementId = swiperContainer.id,
            swiperConfig = SwiperWrapper.getElementConfigFromId(elementId)

        if(!swiperConfig) {
            console.error(`Swiper config for element with id ${elementId} not found.`)
            return
        }

        new Swiper(`.${swiperContainer.classList[0]}`, swiperConfig)
    }

    static getElementConfigFromId(elementId) {
        return {
            latestArticles: {
                direction: 'vertical',
                centeredSlides: true,
                mousewheel: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: ".swiper-pagination",
                    type: "progressbar",
                }
            },
            friendStories: {
                spaceBetween: 30,
                centeredSlides: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false
                },
                pagination: {
                    el: ".swiper-pagination",
                    type: "progressbar",
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                on: {
                    autoplayTimeLeft(s, time, progress) {
                    }
                }
            }
        }[elementId]
    }
}
