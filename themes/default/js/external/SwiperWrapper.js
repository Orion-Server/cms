export default class SwiperWrapper {
    static start() {
        document.addEventListener("turbolinks:load", () => {
            SwiperWrapper.detectSwiperContainers();
        });
    }

    static detectSwiperContainers() {
        const swiperContainers = document.querySelectorAll(".swiper:not(.no-init)");

        Array.from(swiperContainers).forEach((swiperContainer) => {
            SwiperWrapper.createSwiper(swiperContainer);
        });
    }

    static createSwiper(swiperContainer) {
        const elementId = swiperContainer.id,
            swiperConfig = SwiperWrapper.getElementConfigFromId(elementId);

        if (!swiperConfig) {
            console.error(
                `Swiper config for element with id ${elementId} not found.`
            );
            return;
        }

        return new Swiper(`.${swiperContainer.classList[0]}`, swiperConfig);
    }

    static getElementConfigFromId(elementId) {
        return {
            latestArticles: {
                direction: "vertical",
                centeredSlides: true,
                mousewheel: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    type: "progressbar",
                },
            },
            friendStory: {
                direction: "horizontal",
                watchSlidesProgress: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                    stopOnLastSlide: true,
                },
                pagination: {
                    el: '.story_pagination',
                    clickable: true,
                    renderBullet: function (index, className) {
                        return '<div class="' + className + '"><div class="swiper-pagination-progress"></div></div>';
                    },
                },
                navigation: {
                    nextEl: ".story_next",
                    prevEl: ".story_prev",
                },
                on: {
                    autoplayStart(swiper) {
                        document.addEventListener('orion:stop-story', () => {
                            swiper.autoplay?.stop()
                            swiper.destroy(true, true)
                        })
                    },

                    autoplayTimeLeft(swiper, time, progress) {
                        if(!swiper.slides?.length) return;

                        let currentBullet = document.querySelectorAll('.friendStory .swiper-pagination-progress')[swiper.realIndex]

                        if(!currentBullet) return;

                        currentBullet.style.width = Math.min(
                            Math.max(parseFloat(((swiper.params.autoplay.delay - time) * 100 / swiper.params.autoplay.delay).toFixed(1)), 0),
                        100) + '%';

                        if(swiper.isEnd && time <= 0) {
                            swiper.autoplay.stop()
                            swiper.destroy(true, true)

                            setTimeout(() => document.dispatchEvent(new Event('orion:next-story')), 500)
                        }
                    },

                    transitionEnd(swiper) {
                        if(!swiper.slides?.length) return;

                        let allBullets = Array.from(document.querySelectorAll('.friendStory .swiper-pagination-progress')),
                            bulletsBefore = allBullets.slice(0, swiper.realIndex),
                            bulletsAfter = allBullets.slice(swiper.realIndex, allBullets.length);

                        bulletsBefore.forEach(bullet => bullet.style.width = '100%');
                        bulletsAfter.forEach(bullet => bullet.style.width = '0%');

                        let currentSlide = swiper.slides[swiper.realIndex]

                        if(!currentSlide) return;

                        const event = new CustomEvent('orion:current-story-slide', {
                            detail: {
                                currentIndex: swiper.realIndex
                            }
                        })

                        document.dispatchEvent(event)
                    }
                }
            },
        }[elementId];
    }
}
