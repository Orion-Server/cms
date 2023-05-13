<div x-data="textareaEditor">

    <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-slate-800">
        <label for="comment" class="sr-only">Your comment</label>
        <textarea
            id="comment"
            x-ref="textarea"
            rows="6"
            class="w-full focus:outline-none px-0 text-sm text-gray-900 bg-transparent border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400"
            placeholder="Write a comment..."
            required
        ></textarea>
    </div>
    <div class="flex dark:bg-slate-850 bg-gray-100 rounded-b-lg items-center justify-between px-3 py-2 border-t dark:border-gray-600">
        <div class="flex pl-0 space-x-1 sm:pl-2">
            <x-ui.buttons.editor
                icon="fa-solid fa-bold" type="Bold" before="[b]" after="[/b]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-italic" type="Italic" before="[i]" after="[/i]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-strikethrough" type="StrikeThrough" before="[s]" after="[/s]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-underline" type="Underline" before="[u]" after="[/u]"
            />
            <x-ui.buttons.editor
                icon="fa-solid fa-highlighter" type="HighLighter" before="[h]" after="[/h]"
            />
        </div>
        <x-ui.buttons.redirectable
            href="#"
            class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
        >
                Post Comment
        </x-ui.buttons.redirectable>
    </div>

</div>
