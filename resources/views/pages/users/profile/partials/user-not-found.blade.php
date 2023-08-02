<div class="w-full flex flex-col lg:flex-row items-center lg:mt-20 mt-4 justify-center gap-4">
    <img width="125" src="{{ asset('assets/images/frank-not-found.gif') }}" alt="frank-not-found" />
    <div class="flex flex-col gap-3 dark:text-slate-200 text-center lg:text-left">
        <p class="text-2xl font-bold text-red-500">{{ __('User not found.') }}</p>
        <x-ui.buttons.redirectable
            href="{{ route('index') }}"
            class="dark:bg-slate-500 bg-slate-500 border-slate-700 hover:bg-slate-400 dark:hover:bg-slate-400 dark:shadow-slate-700/75 shadow-slate-600/75 py-2 text-white"
        >
            <i class="fas fa-times mr-2"></i>
            {{ __('Back to :n', ['n' => strtolower(__('Index'))]) }}
        </x-ui.buttons.redirectable>
    </div>
</div>
