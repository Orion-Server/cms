<div class="mt-8 flex items-center h-auto relative w-full flex-wrap gap-2">
    <x-ui.buttons.confirmable
        data-tippy-placement="top"
        class="group flex w-12 h-12 items-center justify-center bg-blue-300 dark:bg-blue-600 dark:text-white border-b-2 border-blue-500 rounded-lg"
        :exclusive="true"
    >
        <x-slot:confirmation>
            <div class="flex gap-2">
                <x-ui.buttons.default
                    class="w-8 h-8 bg-green-400 hover:bg-green-500 text-green-800 !border-b-2 border-green-600 rounded-lg">
                    <i class="fa-solid fa-thumbs-up"></i>
                </x-ui.buttons.defaultclass>
                <x-ui.buttons.default
                    class="w-8 h-8 bg-red-400 hover:bg-red-500 text-red-800 !border-b-2 border-red-600 rounded-lg"
                >
                    <i class="fa-solid fa-thumbs-down"></i>
                </x-ui.buttons.defaultclass>
            </div>
        </x-slot:confirmation>

        <x-slot:label>
            <i class="fa-solid fa-plus text-white text-lg"></i>
        </x-slot:label>
    </x-ui.buttons.confirmable>
    @foreach ($activeArticle->reactions as $articleReaction)
        <a
            href="#"
            data-tippy-singleton
            data-tippy-content="<small>{{ $articleReaction->user->username }}</small>"
            class="w-12 h-12 shadow-lg rounded-lg bg-center bg-no-repeat border-b-2 cursor-pointer border-slate-500 dark:border-slate-500"
            style="
                background-color: {{ $articleReaction->reaction->color }};
                background-image: url('{{ getSetting('figure_imager') . $articleReaction->user->look }}&headonly=1')
            "></a>
    @endforeach
</div>
