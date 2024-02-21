<div tabindex="-1"
    class="fixed top-0 left-0 right-0 p-4 overflow-x-hidden bg-slate-950/[0.9] overflow-y-auto md:inset-0 h-full max-h-full hidden justify-center items-center z-[99999]"
    :class="{ 'hidden': !modalOpen, 'flex': modalOpen }"
    x-transition
    x-show="modalOpen"
    x-on:click.self="closeStory()"
    x-on:keydown.escape.prevent.stop="closeStory()"
>
    <div class="relative w-[380px] h-full">
        <div
            class="relative w-full flex flex-col justify-center items-center md:w-auto rounded-xl shadow h-full"
        >
            <div class="!w-[320px] flex justify-start items-center gap-3 p-2 rounded-t-lg bg-slate-900 border border-b-none border-slate-700">
                <div
                    class="w-16 h-16 bg-center bg-no-repeat bg-cover relative rounded-full bg-slate-800"
                    x-bind:style="{ backgroundImage: `url('${getActiveFriendBackground()}')` }"
                >
                    <div
                        @class([
                            "w-full h-full bg-no-repeat",
                            "bg-center" => !$usingNitroImager,
                            "bg-[-15px_-20px]" => $usingNitroImager
                        ])
                        x-bind:style="{ backgroundImage: `url({{ getSetting('figure_imager') }}${getActiveFriendLook()}&headonly=1&head_direction=2&size=m)` }"
                    ></div>
                </div>
                <div class="flex flex-col gap-2">
                    <div class="text-md font-medium text-slate-200" x-html="$sanitize(currentStoryName)"></div>
                    <div class="text-xs text-gray-400 dark:text-slate-500" x-html="getActiveFriendStoryTimestamp()"></div>
                </div>
            </div>
            <div class="friendStory swiper no-init !w-[320px] !h-[320px] rounded-lg rounded-t-none" id="friendStory">
                <div class="swiper-wrapper">
                    <template x-for="(story, index) in currentStories" x-bind:key="index">
                        <div
                            class="swiper-slide w-full h-full relative rounded-lg rounded-t-none"
                            x-bind:style="{ backgroundImage: `url('${story.url}')` }"
                        ></div>
                    </template>
                </div>

                <div class="story_next swiper-button-next"></div>
                <div class="story_prev swiper-button-prev"></div>

                <div class="story_pagination swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
