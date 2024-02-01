<div tabindex="-1"
    class="fixed top-0 left-0 right-0 p-4 overflow-x-hidden bg-black/[0.9] overflow-y-auto md:inset-0 h-full max-h-full hidden justify-center items-center z-[99999]"
    :class="{ 'hidden': !modalOpen, 'flex': modalOpen }"
    x-transition
    x-show="modalOpen"
    x-on:click.self="closeStory()"
    x-on:keydown.escape.prevent.stop="closeStory()"
>
    <div class="relative w-[380px] h-full">
        {{-- <div class="card bg-blue-500 shadow-lg shadow-blue-700/75 w-full h-full rounded-3xl absolute  transform -rotate-3"></div>
        <div class="card bg-blue-400 shadow-blue-600/75 shadow-lg w-full h-full rounded-3xl absolute  transform rotate-3"></div> --}}
        <div class="relative w-full flex justify-center items-center md:w-auto rounded-lg shadow h-full">
            <div class="friendStory swiper no-init !w-[320px] !h-[320px]" id="friendStory">
                <div class="swiper-wrapper">
                    <template x-for="(story, index) in currentStories" x-bind:key="index">
                        <div
                            class="swiper-slide w-full h-full relative rounded-lg"
                            x-bind:style="{ backgroundImage: `url(${story.url})` }"
                        ></div>
                    </template>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="autoplay-progress">
                    <svg viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="20"></circle>
                    </svg>
                    <span></span>
                </div>
            </div>
        </div>
    </div>
</div>
