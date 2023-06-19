<div class="flex">
    <x-ui.buttons.redirectable
        href="{{ route('support.questions.index') }}"
        class="bg-red-500 border-red-700 hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75 py-2 text-white"
    >
        <i class="fa-solid fa-angle-left mr-1"></i>
        {{ __('Back to :n', ['n' => strtolower(__('Index'))]) }}
    </x-ui.buttons.redirectable>
</div>
