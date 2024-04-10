<x-title-box
    icon="user-referrals"
    title="{{ __('My Referrals') }} ({{ $referredUsersCount }})"
    description="{{ __('Refer friends and earn great rewards') }}"
/>
<div class="flex flex-col gap-1 relative mt-4 p-4 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
    <x-ui.input
        type="text"
        icon="fa-regular fa-share-from-square"
        label="{{ __('Your Referral Link') }}"
        id="referral-link"
        :small="true"
        default-value="{{ route('register', ['referral' => \Auth::user()->referral_code]) }}"
        :readonly="true"
    />
    <span class="text-slate-400 text-xs mt-1">
        {{ __('Share the link above to receive great prizes when your friends register.') }}
    </span>
    <span class="text-slate-400 text-xs font-medium mt-1 border-l-2 border-blue-500 dark:border-blue-400 pl-2">
        {!! __('You still need to invite :m to collect the next reward.', ['m' => '<span class="text-blue-500 dark:text-blue-400">5 users</span>']) !!}
    </span>
    <div class="flex items-center justify-end gap-3 mt-2" x-data="{
        init() {
            const clipboard = new ClipboardJS('.trigger-button');

            clipboard.on('success', function (e) {
                e.clearSelection()

                const button = e.trigger

                if(!button) return

                button.classList.add('!bg-green-400', '!border-green-600', '!text-white')
                button.classList.remove('bg-blue-400', 'border-blue-600', 'text-white')

                setTimeout(() => {
                    button.classList.add('bg-blue-400', 'border-blue-600', 'text-white')
                    button.classList.remove('!bg-green-400', '!border-green-600', '!text-white')
                }, 2000);
            });
        }
    }">
        <div class="border-t border-gray-300 dark:border-slate-700 flex-auto"></div>
        <x-ui.buttons.default
            class="trigger-button bg-blue-400 hover:bg-blue-500 text-white border-blue-600 rounded-lg"
            data-tippy
            data-clipboard-target="#referral-link"
            data-tippy-content="<small>{{ __('Click to copy the link') }}</small>"
        >
            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>
            {{ __('Copy Link') }}
        </x-ui.buttons.default>
        <x-ui.buttons.default
            class="bg-green-400 disabled:!bg-slate-400 disabled:!border-slate-600 disabled:!text-slate-300 disabled:cursor-not-allowed hover:bg-green-500 text-green-800 border-green-600 rounded-lg"
            :disabled="true"
        >
        <i class="fa-solid fa-gift mr-1"></i>
            {{ __('Redeem') }}
        </x-ui.buttons.default>
    </div>
</div>
