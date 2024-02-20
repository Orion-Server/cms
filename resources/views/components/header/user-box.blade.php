<div class="relative w-full flex bg-white dark:bg-slate-950 h-24 dark:shadow-none rounded-lg shadow-lg dark:divide-slate-800">
    <div class="w-full h-full flex">
        <div class="w-32 h-full p-1">
            <div class="w-full relative rounded-lg h-full bg-right-bottom bg-no-repeat" style="background-image: url('{{ \Auth::user()?->getAvatarBackground() ?? getSetting('default_avatar_background') }}')">
                <div class="absolute -bottom-6 right-2 w-[73px] h-[57px] bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/stage.png') }}')"></div>
                <div
                    @class([
                        "absolute right-4 w-[64px] h-[110px] bg-center bg-no-repeat",
                        "-bottom-4" => !$usingNitroImager,
                        "-bottom-3" => $usingNitroImager
                    ])
                    style="background-image: url('{{ \Auth::user()?->figure_path ?? '0' }}&direction=2&head_direction=2&size=m&gesture=sml&action=sit,wav')"
                ></div>
            </div>
        </div>
        <div class="w-full flex flex-col">
            <div class="w-full rounded-t-lg flex justify-around items-center divide-x dark:divide-slate-800 h-16 bg-gray-100 dark:bg-gray-900">
                <a
                    class="h-full rounded-tl-lg flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    data-tippy
                    data-tippy-content="<small>{{ __('My Profile') }}</small>"
                    @auth href="{{ route('users.profile.show', Auth::user()->username) }}" @endauth
                >
                    <img src="{{ asset('https://i.imgur.com/wYP2GOf.png') }}" alt="Profile icon" />
                </a>
                <a
                    class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    data-tippy
                    data-tippy-content="<small>{{ __('My Settings') }}</small>"
                    @auth href="{{ route('users.settings.index') }}" @endauth
                >
                    <img src="{{ asset('https://i.imgur.com/zjDy01f.gif') }}" alt="Settings icon" />
                </a>
                <a
                    class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    data-tippy
                    data-tippy-content="<small>{{ __('My Achievements') }}</small>"
                    href=""
                >
                    <img src="{{ asset('https://i.imgur.com/Re6k2iv.png') }}" alt="Achievements icon" />
                </a>
                <a
                    class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    data-tippy
                    data-tippy-content="<small>{{ __('My Inbox') }}</small>"
                    href=""
                >
                    <img src="{{ asset('https://i.imgur.com/d4oZMFz.png') }}" alt="Inbox icon" />
                </a>
                <a
                    class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    data-tippy
                    data-tippy-content="<small>{{ __('Help & Tricks') }}</small>"
                    href="{{ route('support.questions.index') }}"
                >
                    <img src="{{ asset('https://i.imgur.com/jy18kQD.png') }}" alt="Help icon" />
                </a>
            </div>
            <div class="w-full flex justify-start items-center divide-x h-8 dark:divide-slate-800">
                <a
                    class="flex flex-1 h-full rounded-bl-lg items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    href=""
                    data-tippy
                    data-tippy-content="<small>{{ __('My Notifications') }}</small>"
                    data-tippy-placement="bottom"
                >
                    <i class="fa-regular fa-bell text-slate-700 dark:text-white"></i>
                </a>
                <a
                    class="flex flex-1 relative h-full items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-800"
                    href="{{ route('users.purchases') }}"
                    data-tippy
                    data-tippy-content="<small>{{ __('My Purchases') }}</small>"
                    data-tippy-placement="bottom"
                >
                    <i @class([
                        '!text-green-500' => session()->has('shopSuccess'),
                        "fa-solid fa-cart-plus text-slate-700 dark:text-white"
                    ])></i>
                    @if(session()->has('shopSuccess'))
                        <span class="ml-2 text-xxs animate-pulse text-slate-100 py-px px-1 bg-red-500 rounded-full">{{ __('New') }}</span>
                    @endif
                </a>
                <form class="flex-1 flex h-full" action="/logout" method="POST">
                    @csrf
                    <x-ui.buttons.confirmable
                        data-tippy-placement="bottom"
                        class="flex h-full w-full items-center justify-center focus:bg-red-500 group hover:bg-red-100 rounded-br-lg dark:hover:bg-red-300 border-none"
                        :exclusive="true"
                    >
                        <x-slot:confirmation>
                            <x-ui.buttons.default
                                class="text-xs dark:bg-red-600 bg-red-500 border-red-700 hover:bg-red-400 dark:hover:bg-red-500 dark:shadow-red-700/75 shadow-red-600/75 py-2 text-white">
                                {{ __('Confirm') }}
                            </x-ui.buttons.default>
                        </x-slot:confirmation>

                        <x-slot:label>
                            <i class="fa-solid fa-right-from-bracket text-red-500 group-focus:text-white"></i>
                        </x-slot:label>
                    </x-ui.buttons.confirmable>
                </form>
            </div>
        </div>
    </div>
</div>
