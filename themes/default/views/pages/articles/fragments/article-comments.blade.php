<div class="w-full mt-8 flex flex-col gap-4">
    @foreach ($activeArticle->comments as $comment)
    <div @class([
        "bg-white relative w-full flex flex-col overflow-hidden justify-between h-auto dark:text-slate-200 dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg",
        "bg-gradient-to-r from-rose-400 via-fuchsia-500 to-indigo-500 p-0.5" => $comment->fixed
    ])>
        <div @class([
            "p-2 w-full",
            "bg-white dark:bg-slate-950 rounded-t-lg" => $comment->fixed
        ])>
            <div class="w-full flex justify-between text-sm pb-0.5 mb-2 border-b border-gray-100 dark:border-gray-800">
                <span class="w-1/2 font-medium flex gap-1">
                    @if ($comment->fixed)
                        <i
                            data-tippy
                            data-tippy-content="<small>{{ __('This comment is fixed') }}</small>"
                            class="icon small w-[13px] h-[15px] border-none shadow-none rounded-none ifixed"
                        ></i>
                    @endif
                    <a href="{{ route('users.profile.show', $comment->user->username) }}" class="font-bold underline underline-offset-2 text-blue-400">{{ $comment->user->username }}</a> {{ strtolower(__('Commented')) }}:
                </span>
                <span class="w-1/2 text-end text-xs text-slate-400">
                    <i class="fa-regular fa-clock"></i>
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="w-full text-sm text-justify dark:text-light-200 mb-4">
                {!! $comment->renderedContent !!}
            </div>
        </div>
        <div class="w-full h-14 p-1 bg-gray-100 dark:bg-slate-800 rounded-b-lg border-t dark:border-gray-700">
            <div class="w-full relative rounded-lg h-full bg-right-bottom bg-no-repeat">
                <div class="absolute -bottom-8 left-2 w-[73px] h-[57px] bg-center bg-no-repeat" style="background-image: url('{{ asset('assets/images/stage.png') }}')"></div>
                <div
                    @class([
                        "absolute left-2 w-[64px] h-[110px] bg-center bg-no-repeat",
                        "-bottom-6" => !$usingNitroImager,
                        "-bottom-5" => $usingNitroImager
                    ])
                    style="background-image: url('{{ getFigureUrl($comment->user->look, 'direction=2&head_direction=2&size=m&gesture=sml&action=sit,wav') }}')"
                ></div>
                <div class="w-full h-full items-center pl-20 flex gap-2">
                    @foreach ($comment->user->badges as $badge)
                        <div
                            data-tippy
                            data-tippy-content="<small>{{ $badge->badge_code }}</small>"
                            class="w-[48px] bg-center bg-no-repeat h-[48px] rounded-lg bg-white dark:bg-slate-700 dark:border-slate-600 border"
                            style="background-image: url('{{ $badge->getBadgePath() }}')"
                        ></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if ($activeArticle)
        {{ $activeArticle->comments->links() }}
    @endif
</div>
