@props([
    'withEditor' => true
])

<div class="px-4 py-2 bg-white rounded-t-lg dark:bg-slate-800">
    <label for="comment" class="sr-only">Your comment</label>
    <textarea id="comment" rows="6" class="w-full focus:outline-none px-0 text-sm text-gray-900 bg-transparent border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
</div>
@if ($withEditor)
<div class="flex dark:bg-slate-850 bg-gray-100 rounded-b-lg items-center justify-between px-3 py-2 border-t dark:border-gray-600">
    <div class="flex pl-0 space-x-1 sm:pl-2">
        <button
            type="button"
            data-tippy
            data-tippy-content="<small>Bold</small>"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
        >
            <i class="fa-solid fa-bold"></i>
            <span class="sr-only">Bold</span>
        </buttontype=>
        <button
            type="button"
            data-tippy
            data-tippy-content="<small>Italic</small>"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
        >
            <i class="fa-solid fa-italic"></i>
            <span class="sr-only">Italic</span>
        </button>
        <button
            type="button"
            data-tippy
            data-tippy-content="<small>StrikeThrough</small>"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
        >
            <i class="fa-solid fa-strikethrough"></i>
            <span class="sr-only">StrikeThrough</span>
        </button>
        <button
            type="button"
            data-tippy
            data-tippy-content="<small>Underline</small>"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
        >
            <i class="fa-solid fa-underline"></i>
            <span class="sr-only">Underline</span>
        </button>
        <button
            type="button"
            data-tippy
            data-tippy-content="<small>Highlighter</small>"
            class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600"
        >
            <i class="fa-solid fa-highlighter"></i>
            <span class="sr-only">Highlighter</span>
        </button>
    </div>
    <x-ui.buttons.redirectable
        href="#"
        class="dark:bg-blue-600 text-sm bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
    >
            Post Comment
    </x-ui.buttons.redirectable>
</div>
@endif
