<div class="flex flex-col space-y-0.5" data-turbolinks-scroll>
    @if($user->friends->isNotEmpty())
    <div class="grid grid-cols-2 gap-1.5 friends p-1">
        @foreach($user->friends as $friend)
        <div class="flex p-0.5 gap-1 border bg-black/20 border-dashed border-black/50 relative">
            <div @class([
                "w-[33px] h-[56px]",
                "bg-[-7px_-7px]" => $usingNitroImager
            ])
                style="background-image: url('{{ getFigureUrl($friend->user->look, 'direction=4&head_direction=4&action=sml&size=s') }}')"
            ></div>
            <div class="w-[70px] h-full">
                <a class="block underline text-amber-950 text-xxs font-semibold truncate" href="{{ route('users.profile.show', $friend->user->username) }}">{{ $friend->user->username }}</a>
                <span class="text-xxs italic text-black">{{ \Carbon\Carbon::parse($friend->user->account_created)->toFormattedDateString() }}</span>
            </div>
        </div>
        @endforeach
    </div>
        @if($user->friends instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-2">
            {!! $user->friends?->withQueryString()->links('vendor.pagination.home-widget') !!}
        </div>
        @endif
    @else
    <span class="font-semibold text-xss text-center">
        {{ __(':username does not have any friends yet.', ['username' => $user->username]) }}
    </span>
    @endif
</div>
