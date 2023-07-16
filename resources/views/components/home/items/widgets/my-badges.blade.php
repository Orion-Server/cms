<div class="block badges" x-data="badgesWidget()" data-turbolinks-scroll>
    <div class="grid grid-cols-4 gap-1">
        @forelse($user->badges as $badge)
        <div class="w-[40px] h-[40px] bg-center bg-no-repeat" style="background-image: url({{ $badge->getBadgePath() }})"></div>
        @empty
        <span class="font-semibold text-xss text-center">
            {{ __(':username does not have any badges yet.', ['username' => $user->username]) }}
        </span>
        @endforelse
    </div>
    @if($user->badges instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-2">
        {!! $user->badges?->links('vendor.pagination.home-widget') !!}
    </div>
    @endif
</div>
