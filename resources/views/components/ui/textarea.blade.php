@props([
    'route' => null,
    'id' => 'textarea-editor',
    'placeholder' => __('Write something here...'),
    'actions' => null,
    'automaticPreview' => false,
])

<form
    @submit.prevent="onSubmit"
    x-data="textareaEditor({{ $automaticPreview }})"
    action="{{ $route }}"
    x-ref="form"
>
    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-slate-800">
        <label for="{{ $id }}" class="sr-only">Textarea Editor</label>
        <textarea
            x-show="!showPreview"
            id="{{ $id }}"
            x-ref="textarea"
            @input.prevent.debounce.500ms="requestPreview()"
            rows="6"
            class="w-full min-h-[150px] focus:outline-none px-0 text-sm text-gray-900 bg-transparent border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400"
            placeholder="{{ $placeholder }}"
            required
        ></textarea>

        <template x-if="showPreview">
            <div class="min-h-[150px] text-sm dark:text-white text-gray-900" x-html="previewText"></div>
        </template>
    </div>
    <div class="flex flex-col flex-wrap gap-2 lg:flex-row dark:bg-slate-850 bg-gray-100 rounded-b-lg items-center justify-between px-3 py-2 border-t dark:border-gray-600">
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

        <div class="inline-flex gap-2 flex-wrap justify-center">
            {{ $actions }}
        </div>
    </div>

</form>
