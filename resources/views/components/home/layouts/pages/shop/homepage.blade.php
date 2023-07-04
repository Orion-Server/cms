<div class="flex px-4 flex-col justify-start gap-3 items-center h-full">
    <img src="https://i.imgur.com/8Hi6Sqb.png" alt="Home Image" />
    <span class="font-bold dark:text-slate-200">
        {{ __('Welcome to :h home shop!', ['h' => config('app.name')]) }}
    </span>
    <span class="font-medium text-sm dark:text-slate-400">
        {{ __('Here you can buy stickers, notes, widgets and backgrounds that you like and customize your page the way you want. Enjoy!') }}
    </span>
    <span class="font-normal text-xs dark:text-slate-400">
        {{ __('Build your page and send the link to your friends.') }} <i class="fa-solid fa-face-laugh-beam"></i>
    </span>
</div>
