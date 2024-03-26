<div class="flex relative flex-col gap-1 p-1 border-b border-dashed border-black pb-10">
    <a class="underline font-bold" href="{{ route("users.profile.show", $user->username) }}">{{ $user->username }}</a>
    @if($user->online)
    <img width="37" src="https://imgur.com/7dYNPU5.png"/>
    @else
    <img width="40" src="https://imgur.com/6Vha5x4.png"/>
    @endif
    <span class="max-w-[120px] text-xss">
        {{ __('Created on:') }}
        <br>
        {{ \Carbon\Carbon::parse($user->account_created)->format('Y-m-d H:i') }}
    </span>
    <div @class([
        "w-[64px] absolute bottom-1",
        "h-[110px] right-6" => !$usingNitroImager,
        "h-[130px] right-7" => $usingNitroImager
    ]) style="background-image: url('{{ getFigureUrl($user->look, 'direction=4&head_direction=4&size=m&gesture=sml') }}')"></div>
</div>
<div class="mt-1 block">
    <span class="my-1 text-xs block">{{ $user->motto }}</span>
    <div class="border border-white bg-neutral-300/50 p-1">
        {{ __('No tags found') }}
    </div>
    @if(Auth::check() && $user->id == Auth::id())
    <div class="mt-1 space-y-1 block">
        <input class="bg-white border w-full h-6 outline-none p-1 border-black/75 shadow-inner" />
        <x-ui.buttons.default
            disabled
            class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-0.5 text-xs text-white"
        >
            {{ __('Add tag') }}
        </x-ui.buttons.default>
    </div>
    @endif
</div>
