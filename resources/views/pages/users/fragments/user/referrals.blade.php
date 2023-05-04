<x-title-box
    icon="user-referrals"
    title="Your Referrals"
    description="Refer friends and earn great rewards"
/>
<div class="flex flex-col gap-1 relative mt-4 p-4 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
    <x-ui.input
        type="text"
        icon="fa-regular fa-share-from-square"
        label="Your Referral Link"
        placeholder="Referral Link"
        id="referral-link"
        :small="true"
        default-value="{{ route('register', ['referral' => auth()->user()->username]) }}"
        :disabled="true"
    />
    <span class="text-slate-400 text-xs mt-1">
        Share the link above to receive great prizes when your friends register.
    </span>
    <span class="text-slate-400 text-xs font-medium mt-1 border-l-2 border-blue-500 dark:border-blue-400 pl-2">
        You still need to invite <span class="text-blue-500 dark:text-blue-400">5 users</span> to collect a reward.
    </span>
    <div class="flex gap-3 mt-2" x-data="{
        copyLink(event) {
            const buttonContent = event.target.innerHTML

            navigator.clipboard.writeText(document.getElementById('referral-link').value)
            event.target.innerHTML = 'Successfull!'

            setTimeout(() => event.target.innerHTML = buttonContent, 2000)
        }
    }">
        <x-ui.buttons.default
            class="bg-blue-400 w-1/2 hover:bg-blue-500 text-white !border-b-2 border-blue-600 rounded-lg"
            data-tippy
            @click.debounce.500ms="copyLink"
            data-tippy-content="<small>Click to copy the link</small>"
        >
            <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>
            Copy Link
        </x-ui.buttons.default>
        <x-ui.buttons.default
            class="w-1/2 bg-green-400 disabled:!bg-slate-400 disabled:!border-slate-600 disabled:!text-slate-300 disabled:cursor-not-allowed hover:bg-green-500 text-green-800 !border-b-2 border-green-600 rounded-lg"
            :disabled="true"
        >
        <i class="fa-solid fa-gift mr-1"></i>
            Redeem
        </x-ui.buttons.default>
    </div>
</div>
