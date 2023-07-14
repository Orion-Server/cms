<div class="flex flex-col space-y-0.5 groups pr-1">
    @forelse($user->guilds as $memberData)
    <div class="flex p-0.5 gap-1 bg-neutral-400/75 border border-dashed border-black/25">
        <div
            class="w-[40px] h-[40px] bg-center bg-no-repeat"
            style="background-image: url('https://imager.blet.in/badge/{{ $memberData->guild->badge }}.gif')"
        ></div>
        <div class="-space-y-1 text-xss flex flex-col" style="max-width: calc(100% - 45px)">
            <span class="font-bold truncate underline mb-px">{{ $memberData->guild->name }}</span>
            <span class="text-xxs">{{ __('Group created in') }}</span>
            <span class="text-xxs font-semibold">{{ \Carbon\Carbon::parse($memberData->guild->date_created)->format('Y-m-d H:i') }}</span>
        </div>
    </div>
    @empty
    <span class="font-semibold text-xss text-center">
        {{ __(':username does not have any groups yet.', ['username' => $user->username]) }}
    </span>
    @endforelse
</div>
