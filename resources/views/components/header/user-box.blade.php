<div class="w-full flex lg:w-2/4 xl:w-1/3 bg-white dark:bg-slate-950 h-24 dark:shadow-none rounded-lg shadow-lg dark:divide-slate-800">
    <div class="w-3/4 flex flex-col">
        <div class="w-full rounded-t-lg flex justify-around items-center divide-x dark:divide-slate-800 h-16 bg-gray-100 dark:bg-gray-900">
            <a
                class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                data-tippy
                data-tippy-content="<small>My Profile</small>"
                href=""
            >
                <img src="{{ asset('assets/images/icons/big/profile.png') }}" alt="Profile icon" />
            </a>
            <a
                class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                data-tippy
                data-tippy-content="<small>My Settings</small>"
                href=""
            >
                <img src="{{ asset('assets/images/icons/big/settings.gif') }}" alt="Settings icon" />
            </a>
            <a
                class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                data-tippy
                data-tippy-content="<small>My Achievements</small>"
                href=""
            >
                <img src="{{ asset('assets/images/icons/big/achievements.png') }}" alt="Achievements icon" />
            </a>
            <a
                class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                data-tippy
                data-tippy-content="<small>My Inbox</small>"
                href=""
            >
                <img src="{{ asset('assets/images/icons/big/inbox.png') }}" alt="Inbox icon" />
            </a>
            <a
                class="h-full flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-slate-800"
                data-tippy
                data-tippy-content="<small>Help & Suggestions</small>"
                href=""
            >
                <img src="{{ asset('assets/images/icons/big/help.png') }}" alt="Help icon" />
            </a>
        </div>
        <div class="w-1/2 flex justify-start items-center divide-x h-8 dark:divide-slate-800">
            <a
                class="flex flex-1 h-full rounded-bl-lg items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-800"
                href=""
                data-tippy
                data-tippy-content="<small>My Notifications</small>"
                data-tippy-placement="bottom"
            >
                <i class="fa-regular fa-bell text-slate-700 dark:text-white"></i>
            </a>
            <a
                class="flex flex-1 h-full items-center justify-center hover:bg-gray-50 dark:hover:bg-slate-800"
                href=""
                data-tippy
                data-tippy-content="<small>My Purchases</small>"
                data-tippy-placement="bottom"
            >
                <i class="fa-solid fa-cart-plus text-slate-700 dark:text-white"></i>
            </a>
        </div>
    </div>
    <div class="w-1/4 h-full p-1">
        <div class="w-full relative rounded-lg h-full bg-right-bottom bg-no-repeat" style="background-image: url('{{ asset('assets/images/user-box-bg.gif') }}')">
            <div class="absolute -bottom-6 right-2 w-[73px] h-[57px] bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/stage.png') }}')"></div>
            <div
                class="absolute -bottom-4 right-2 w-[64px] h-[110px] bg-center bg-no-repeat"
                style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=ferrazmatheus&direction=4&head_direction=4&size=m&gesture=sml&action=sit,wav')"
            ></div>
        </div>
    </div>
</div>
