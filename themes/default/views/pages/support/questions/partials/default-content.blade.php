<div class="flex flex-col justify-center items-center gap-2">
    <span class="text-3xl font-bold text-slate-800 dark:text-slate-200 underline underline-offset-4 decoration-emerald-500">
        {{ __('Categories') }}
    </span>
    <span class="text-sm dark:text-slate-400 text-slate-600">
        {{ __("Maybe you'll find what you're looking for in one of these categories.") }}
    </span>
</div>

<div class="flex gap-2 flex-wrap justify-center">
    @foreach ($categories as $category)
        <x-ui.buttons.redirectable
            href="{{ route('support.questions.categories.show', $category->slug) }}"
            class="bg-emerald-500 border-emerald-700 hover:bg-emerald-400 dark:shadow-emerald-700/75 shadow-emerald-600/75 py-2 text-white"
        >
            <img src="{{ $category->icon }}" alt="{{ $category->name }}" loading="lazy" />
            {{ $category->name }}
        </x-ui.buttons.redirectable>
    @endforeach
</div>

<div class="flex gap-3 mt-8 justify-between flex-col lg:flex-row">
    <div class="w-full lg:w-1/2">
        <x-title-box
            title="{{ __('Most Asked Questions') }}"
            icon="most-asked-questions"
        />

        <div class="flex flex-col gap-2 p-4 divide-y dark:divide-slate-800 dark:text-slate-200 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
            @foreach ($mostAskedQuestions as $question)
                <a
                    href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
                    class="hover:underline py-3 text-blue-500 text-sm hover:text-blue-700"
                >
                    <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
                    {{ $question->title }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="w-full lg:w-1/2">
        <x-title-box
            title="{{ __('Added Recent Questions') }}"
            icon="added-recent-questions"
        />

        <div class="flex flex-col divide-y dark:divide-slate-800 p-4 dark:text-slate-200 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
            @foreach ($addedRecentQuestions as $question)
                <a
                    href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
                    class="hover:underline py-3 text-blue-500 text-sm hover:text-blue-700"
                >
                    <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
                    {{ $question->title }}
                </a>
            @endforeach
        </div>
    </div>
</div>
