<div class="mt-8 flex items-center h-auto relative w-full flex-wrap gap-2"
    x-data="articleReactions('{{ route('articles.reactions.toggle', [$activeArticle->id, $activeArticle->slug, ':reactionId']) }}')"
>
    @auth
        <x-ui.buttons.confirmable
            data-tippy-placement="top"
            class="group flex w-12 h-12 items-center justify-center bg-blue-300 dark:bg-blue-600 dark:text-white border-b-2 border-blue-500 rounded-lg"
            :exclusive="true"
        >
            <x-slot:confirmation>
                <div class="flex gap-2">
                    @foreach ($allReactions as $reaction)
                    <x-ui.buttons.default
                        @click="addReaction({{ $reaction->id }})"
                        class="w-8 h-8 inline-block hover:brightness-125 !bg-no-repeat !bg-center !border-none rounded-lg"
                        style="background: {{ $reaction->color }} url({{ $reaction->completeIconPath }});"
                    />
                    @endforeach
                </div>
            </x-slot:confirmation>

            <x-slot:label>
                <i class="fa-solid fa-plus text-white text-lg"></i>
            </x-slot:label>
        </x-ui.buttons.confirmable>
    @endauth

    @foreach ($activeArticle->reactions as $articleReaction)
        <a
            href="#"
            data-tippy-singleton
            data-tippy-content="<small>{{ $articleReaction->user->username }}</small>"
            class="w-12 h-12 shadow-sm rounded-lg bg-center bg-no-repeat cursor-pointer"
            style="
                background-color: {{ $articleReaction->reaction->color }};
                background-image: url('{{ getSetting('figure_imager') . $articleReaction->user->look }}&headonly=1')
            "></a>
    @endforeach
</div>
