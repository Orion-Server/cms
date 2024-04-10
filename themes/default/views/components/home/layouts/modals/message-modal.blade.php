<x-ui.modal
    title="{{ __('Send a message') }}"
    alpine-model="guestbookStore.showModal"
>
    <div class="bg-slate-100 dark:bg-slate-850 rounded mt-2 text-left p-1">
        <x-ui.textarea
            id="guestbook-message-input"
        >
            <x-slot:actions>
                <x-ui.buttons.loadable
                    type="button"
                    alpine-model="guestbookStore.delay"
                    class="dark:bg-orange-500 send-message-button bg-orange-500 border-orange-700 hover:bg-orange-400 dark:hover:bg-orange-400 dark:shadow-orange-700/75 shadow-orange-600/75 py-2 text-white"
                >
                    <i class="fa-solid fa-message mr-1"></i>
                    {{ __('Send') }}
                </x-ui.buttons.loadable>
            </x-slot:actions>
        </x-ui.textarea>
    </div>
</x-ui.modal>
