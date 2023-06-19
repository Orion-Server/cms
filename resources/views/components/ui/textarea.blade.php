@props([
    'articleId' => null,
    'articleSlug' => null,
])

<form
    @submit.prevent="onSubmit"
    x-data="textareaEditor"
    action="{{ route('articles.comments.store', [$articleId, $articleSlug]) }}"
    x-ref="form"
>
    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-slate-800">
        <label for="comment" class="sr-only">Your comment</label>
        <textarea
            x-show="!showPreview"
            id="comment"
            x-ref="textarea"
            rows="6"
            class="w-full focus:outline-none px-0 text-sm text-gray-900 bg-transparent border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400"
            placeholder="{{ __('Write a comment...') }}"
            required
        ></textarea>

        <template x-if="showPreview">
            <div class="min-h-[120px] text-sm dark:text-white text-gray-900" x-html="previewText"></div>
        </template>
    </div>
    <div class="flex flex-col gap-2 lg:flex-row dark:bg-slate-850 bg-gray-100 rounded-b-lg items-center justify-between px-3 py-2 border-t dark:border-gray-600">
        <div x-show="!showPreview" class="flex pl-0 space-x-1 sm:pl-2">
            <x-ui.buttons.editor
                icon="fa-solid fa-bold" type="{{ __('Bold') }}" before="[b]" after="[/b]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-italic" type="{{ __('Italic') }}" before="[i]" after="[/i]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-strikethrough" type="{{ __('StrikeThrough') }}" before="[s]" after="[/s]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-underline" type="{{ __('Underline') }}" before="[u]" after="[/u]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-highlighter" type="{{ __('HighLighter') }}" before="[h]" after="[/h]"
            />
        </div>

        <div class="inline-flex gap-2">
            <x-ui.buttons.loadable
                alpine-model="previewLoading"
                @click="onPreviewRequest"
                type="button"
                class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
            >
                <template x-if="!showPreview">
                    <span>
                        <i class="fa-solid fa-eye mr-1"></i>
                        {{ __('Preview') }}
                    </span>
                </template>

                <template x-if="showPreview">
                    <span>
                        <i class="fa-solid fa-arrow-rotate-left mr-1"></i>
                        {{ __('Back to Form') }}
                    </span>
                </template>
            </x-ui.buttons.loadable>

            <template x-if="!showPreview">
                <x-ui.buttons.loadable
                    alpine-model="loading"
                    type="submit"
                    class="dark:bg-green-500 bg-green-500 border-green-700 hover:bg-green-400 dark:hover:bg-green-400 dark:shadow-green-700/75 shadow-green-600/75 py-2 text-white"
                >
                    <i class="fa-solid fa-message mr-1"></i>
                    {{ __('Post Comment') }}
                </x-ui.buttons.loadable>
            </template>
        </div>
    </div>

</form>
