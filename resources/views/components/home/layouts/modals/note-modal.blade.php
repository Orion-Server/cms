<x-ui.modal
    title="{{ __('Editing note') }}"
    alpine-model="itemsStore.showNoteEditingModal"
>
    <div class="bg-slate-100 dark:bg-slate-850 rounded mt-2 text-left p-1">
        <x-ui.textarea :automatic-preview="true">
            <x-slot:actions>
                <x-ui.buttons.loadable
                    type="button"
                    alpine-model="previewLoading"
                    @click="itemsStore.saveNoteData($refs.textarea.value, previewText)"
                    class="dark:bg-orange-500 bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                >
                    <i class="fa-solid fa-message mr-1"></i>
                    {{ __('Save') }}
                </x-ui.buttons.loadable>
            </x-slot:actions>
        </x-ui.textarea>
    </div>
</x-ui.modal>
