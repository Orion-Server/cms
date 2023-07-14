<div class="flex flex-col space-y-0.5 groups pr-1">
    @foreach($user->guilds as $memberData)
    <div class="flex p-0.5 gap-1 bg-neutral-400/75 border border-dashed border-black/25">
        <div
            class="w-[40px] h-[40px] bg-center bg-no-repeat"
            style="background-image: url('https://imager.blet.in/badge/{{ $memberData->guild->badge }}.gif')"
        ></div>
        <div class="max-w-[120px] text-xss flex flex-col">
            <span class="m-0 font-bold truncate underline">{{ $memberData->guild->name }}</span>
            <span class="m-0 text-xxs">{{ __('Group created in') }}</span>
            <span class="m-0 text-xxs">{{ \Carbon\Carbon::parse($memberData->guild->date_created)->format('Y-m-d H:i') }}</span>
        </div>
    </div>
    @endforeach
</div>
