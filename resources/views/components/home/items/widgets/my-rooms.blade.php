<div class="flex flex-col space-y-0.5 rooms p-1">
    @forelse($user->rooms as $room)
    <div class="flex py-1 px-0.5 gap-1 border-b border-dashed border-black/50 relative">
        <div @class([
            "w-[45px] h-[45px] bg-center bg-no-repeat",
            "opened-room" => in_array($room->state, ['open', 'invisible']),
            "locked-room" => $room->state == 'locked',
            "password-room" => $room->state == 'password'
        ])></div>
        <div class="-space-y-1 text-xss flex flex-col gap-y-1.5" style="max-width: calc(100% - 45px)">
            <span class="font-bold leading-3 mb-px">{{ $room->name }}</span>
            <span class="text-xxs leading-3">{{ $room->description }}</span>
        </div>
    </div>
    @empty
    <span class="font-semibold text-xss text-center">
        {{ __(':username does not have any rooms yet.', ['username' => $user->username]) }}
    </span>
    @endforelse
</div>
