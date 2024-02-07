<div class="flex flex-col gap-6 mt-4">
    <div class="flex flex-col">
        <x-ui.input
            label="{{ __('Username') }}"
            autocomplete="username"
            id="change-username"
            icon="fa-solid fa-user"
            alpine-model="data.newUsername"
            placeholder="{{ __('Username') }}"
            type="text"
        />
    </div>

    <div class="flex-1 flex flex-col">
        <label class="text-gray-700 w-full text-left font-semibold mb-2 dark:text-gray-200 text-sm">
            <i class="fa-solid fa-venus-mars mr-1"></i>
            {{ __('Gender') }}
        </label>
        <div class="flex gap-2">
            <div class="flex-1">
                <x-ui.input-radio
                    id="register-gender"
                    title="{{ __('Male') }}"
                    image-icon="small male"
                    value="M"
                    alpine-model="data.gender"
                    selected-classes="peer-checked:!text-blue-400 peer-checked:border-blue-400"
                />
            </div>
            <div class="flex-1">
                <x-ui.input-radio
                    id="login-gender"
                    title="{{ __('Female') }}"
                    image-icon="small female"
                    value="F"
                    alpine-model="data.gender"
                    selected-classes="peer-checked:!text-pink-400 peer-checked:border-pink-400"
                    :render-input="false"
                />
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <x-ui.buttons.loadable
            alpine-model="loading"
            @click="submitForm()"
            class="dark:bg-primary-500 bg-primary-500 border-primary-700 hover:bg-primary-400 dark:hover:bg-primary-400 dark:shadow-primary-700/75 shadow-primary-600/75 py-2 text-white"
        >
            {{ __('Submit') }}
        </x-ui.buttons.loadable>
    </div>
</div>
