@auth
    @if(Auth::user()->settings->can_change_name)
    <div x-data="changeUsername('{{ route('users.settings.change-username') }}')">
        <span @click="modalOpen = true" class="w-full h-12 flex gap-2 justify-center items-center bg-green-500 text-green-800 font-bold cursor-pointer">
            <i class="fa-solid fa-signature"></i>
            {{ __('Your account is approved for a name change. Click here and create your new username.') }}
        </span>

        <x-ui.modal
            title="{{ __('Change username') }}"
            type="change-username"
        />
    </div>
    @endif
@endauth
