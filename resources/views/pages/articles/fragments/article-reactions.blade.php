@php($allUserReactions = $activeArticle->reactions->where('user_id', Auth::id())->pluck('type.value'))
@php($availableReactions = $articleReactions->whereNotIn('value', $allUserReactions))

<div class="mt-8 flex items-center h-auto relative w-full flex-wrap gap-2" x-data="articleReaction('{{ route('articles.reactions.toggle', [$activeArticle->id, $activeArticle->slug]) }}')">
    @auth
        @unless($availableReactions->isEmpty())
        <x-ui.buttons.confirmable
            data-tippy-placement="top"
            class="group flex w-12 h-12 items-center justify-center bg-rose-300 dark:bg-rose-400 dark:text-white border-b-2 border-rose-500 rounded-lg"
            :exclusive="true"
        >
            <x-slot:confirmation>
                <div class="flex gap-2 bg-black/25 rounded-lg p-1">
                    @foreach ($availableReactions as $reaction)
                        <x-ui.buttons.default
                            data-type="{{ $reaction->value }}"
                            @click="toggleReaction"
                            class="w-8 h-8 rounded-md border-none shadow-[inset_0_-3px_0_0_rgba(0,0,0,0.5)] hover:brightness-125"
                            style="background: url({{ $reaction->getIcon() }}) center no-repeat, {{ $reaction->getColor() }}"
                        />
                    @endforeach
                </div>
            </x-slot:confirmation>

            <x-slot:label>
                <i class="fa-solid fa-plus text-white text-lg"></i>
            </x-slot:label>
        </x-ui.buttons.confirmable>
        @endunless
    @endauth

    @foreach ($activeArticle->reactions as $reaction)
        <div
            onclick="Turbolinks.visit('{{ route('users.profile.show', $reaction->user->username) }}')"
            data-tippy-singleton
            data-tippy-content="<small>{{ $reaction->user->username }}</small>"
            @class([
                "w-12 h-12 group shadow-lg relative rounded-lg bg-center bg-no-repeat border-b-2 cursor-pointer even:bg-blue-300 dark:even:bg-blue-600 bg-blue-400 dark:bg-blue-400 dark:text-white border-blue-500",
                "bg-center" => !$usingNitroImager,
                "bg-[-20px_-27px]" => $usingNitroImager
            ])
            style="background-image: url('{{ getFigureUrl($reaction->user->look, 'head_direction=2&size=m&gesture=sml&headonly=1') }}')"
        >
            <div
                class="absolute -bottom-0.5 left-0 w-[20px] h-[20px]"
                style="background: url({{ $reaction->type->getIcon() }}) center no-repeat"
            ></div>

            @if (Auth::check() && $reaction->user_id === Auth::id())
                <i
                    data-type="{{ $reaction->type->value }}"
                    @click.stop="toggleReaction"
                    class="fas fa-times fa-xs invisible absolute group-hover:visible -top-1 -right-1 bg-red-500 rounded-full p-1 py-2 text-white"
                ></i>
            @endif
        </div>
    @endforeach
</div>
