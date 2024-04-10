<div class="flex flex-col gap-6 mt-4">
    <div class="flex flex-col divide-y dark:divide-slate-800 overflow-y-auto p-1" style="max-height: 350px !important">
        @forelse ($availableLanguages as $countryCode => $languageName)
            <a
                href="{{ route('set-language', $countryCode) }}"
                class="hover:underline underline-offset-4 hover:bg-slate-100 dark:hover:bg-slate-950 flex items-center gap-2 py-3 dark:text-slate-200 text-slate-800 font-medium text-sm"
                data-turbolinks="false"
            >
                <img src="{{ sprintf('/assets/images/country-flags/%s.png', $countryCode) }}" alt="{{ $languageName }}" loading="lazy" />
                {{ $languageName }}
            </a>
        @empty
        <span class="text-slate-400 dark:text-slate-500">
            No languages were found on this website.
        </span>
        @endforelse
    </div>

    <div class="flex justify-end">
        <x-ui.buttons.redirectable
            @click="storeActionLocally()"
            class="dark:bg-red-500 bg-red-500 border-red-700 hover:bg-red-400 dark:hover:bg-red-400 dark:shadow-red-700/75 shadow-red-600/75 py-2 text-white"
        >
            <i class="fas fa-times mr-2"></i>
            {{ __('Dont show this again') }}
        </x-ui.buttons.redirectable>
    </div>
</div>
