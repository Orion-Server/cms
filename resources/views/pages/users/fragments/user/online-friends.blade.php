@php($randomOnlineFriends = random_int(5, 20))

<x-title-box
    icon="online-friends"
    title="Online Friends ({{ $randomOnlineFriends }})"
    description="See which friends are online now"
/>
<div class="flex gap-3 scroll-smooth scroll-x relative mt-4 p-2 pb-6 overflow-x-auto rounded-lg shadow border-b-2 border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
    @for ($i = 0; $i < $randomOnlineFriends; $i++)
        <div class="w-14 h-14 relative shrink-0 rounded-full dark:bg-slate-800 border border-gray-300 dark:border-slate-700 p-0.5 cursor-pointer">
            <div class="w-full h-full rounded-full bg-center bg-no-repeat" style="background-image: url('https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=png&user=nicollas1073&direction=4&head_direction=3&size=m&gesture=sml&headonly=1')"></div>
            <div class="absolute max-w-[100%] truncate text-xs -bottom-5 left-1/2 -translate-x-1/2 dark:text-slate-200">iNicollas</div>
        </div>
    @endfor
</div>
