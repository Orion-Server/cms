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

        new Swiper(`.${swiperContainer.classList[0]}`, swiperConfig);
    }

    static getElementConfigFromId(elementId) {
        const progressCircle = document.querySelector(".autoplay-progress svg");
        const progressContent = document.querySelector(".autoplay-progress span");

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
                direction: "vertical",
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                    stopOnLastSlide: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                on: {
                    autoplayStart(s) {
                        document.addEventListener('orion:stop-story', () => {
                            s.autoplay?.stop()
                            s.destroy()
                        })
                    },
                    autoplayTimeLeft(s, time, progress) {
                        if(!s.slides.length) return;

                        progressCircle.style.setProperty("--progress", 1 - progress)
                        progressContent.textContent = `${Math.ceil(time / 1000)}s`
                    },
                    reachEnd(s) {
                        setTimeout(() => {
                            s.autoplay.stop()
                            s.destroy()

                            document.dispatchEvent(new Event('orion:next-story'))
                        }, 5500)
                    },
                }
            },
        }[elementId];
    }
}
