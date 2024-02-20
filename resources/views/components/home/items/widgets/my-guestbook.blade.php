<div class="block" data-turbolinks-scroll>
    <div class="messages p-1">
        @forelse ($user->myHomeMessages as $message)
            <div class="border-b border-dashed border-black/75 flex pb-1">
                <div @class([
                        "w-[33px] h-[56px]",
                        "bg-[-9px_-7px]" => $usingNitroImager
                    ])
                    style="background-image: url('{{ getFigureUrl($message->user->look, 'direction=4&head_direction=4&action=sml&size=s') }}')"
                ></div>
                <div class="w-[215px] flex flex-col">
                    <div class="flex gap-1 pt-1">
                        <img @class([
                            'opacity-40' => $message->user->online == 0,
                            'animate__animated animate__pulse animate__infinite' => $message->user->online == 1,
                        ]) src="https://imgur.com/x0QPPlT.png" alt="online" class="w-[13x] h-[16px] inline-block">
                        <a class="underline underline-offset-2 font-semibold text-xss text-amber-950 max-w-[180px] truncate" href="{{ route('users.profile.show', $message->user->username) }}">{{ $message->user->username }}</a>
                    </div>
                    <div class="mt-1 text-xss max-h-[150px] overflow-y-auto">
                        {!! $message->renderedContent !!}
                    </div>
                    <span class="text-end text-xxs text-black/50 p-px">
                        {{ $message->created_at->toDayDateTimeString() }}
                    </span>
                </div>
            </div>
        @empty
        <span class="font-semibold block text-xss text-center">
            {{ __(":username hasn't received any messages yet.", ['username' => $user->username]) }}
        </span>
        @endforelse
    </div>
    @auth
    <div class="flex justify-end mt-2">
        <x-ui.buttons.default
            class="dark:bg-blue-500 guestbook-button-trigger bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-0.5 text-xs text-white"
        >
            {{ __('Send a message') }}
        </x-ui.buttons.default>
    </div>
    @endauth
</div>
