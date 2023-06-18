@php($widgetId = getSetting('discord_widget_id'))

@if($widgetId)
<div class="flex flex-col gap-4" id="discord-widget" x-data="discordWidget('{{ $widgetId }}')">
    <x-title-box
        icon="discord"
        title="{{ __('Our Widget') }}"
    />
    <div class="p-1.5 rounded-lg shadow border-b-2 min-h-[2.5rem] border-gray-300 dark:border-slate-800 bg-white dark:bg-slate-950">
        <template x-if="loading || failed">
            <div class="w-full text-center py-1 text-sm text-slate-500">
                <template x-if="loading">
                    <div>
                        <i class="fa-solid fa-circle-notch fa-spin mr-1"></i>
                        {{ __('Loading widget...') }}
                    </div>
                </template>

                <template x-if="!loading && failed">
                    <div>
                        <i class="fa-solid fa-exclamation-circle mr-1"></i>
                        {{ __('Failed to load widget') }}
                    </div>
                </template>
            </div>
        </template>

        <template x-if="!loading && discordData">
            <div>
                <div class="w-full h-10 border-indigo-500 border-b-2 mb-2 flex text-white justify-between items-center p-2">
                    <a x-bind:href="getInviteLink()" target="_blank" class="text-indigo-500 flex-1 font-semibold text-sm hover:underline underline-offset-4">
                        <i class="fa-solid fa-share"></i>
                        <span x-text="getName()"></span>
                    </a>
                    <template x-if="discordData.presence_count">
                        <div class="flex gap-1 items-center">
                            <i class="fa-solid fa-circle text-green-500 fa-beat-fade fa-2xs"></i>
                            <span class="text-xs font-bold text-slate-900 dark:text-slate-200" x-text="getOnlineUsersCount()"></span>
                        </div>
                    </template>
                </div>
                <template x-if="hasMembers()">
                    <div class="flex flex-col max-h-[15rem] overflow-y-auto">
                        <template x-for="(member, index) in getMembers()" :key="index">
                            <div class="flex h-11 items-center gap-2 p-1 relative odd:bg-gray-100 dark:odd:bg-slate-900">
                                <div class="w-8 h-8 bg-center bg-no-repeat bg-cover rendering-quality rounded-full" x-bind:style="{ backgroundImage: `url('${member.avatar_url}')` }"></div>
                                <div class="flex-1 flex gap-2 justify-start items-center truncate">
                                    <i
                                        class="fa-solid fa-circle fa-2xs"
                                        :class="{
                                            'text-green-500': member.status == 'online',
                                            'text-yellow-500': member.status == 'idle',
                                            'text-red-500': member.status == 'dnd'
                                        }"
                                    ></i>
                                    <div class="flex flex-col truncate">
                                        <span class="text-sm font-medium dark:text-slate-200" x-text="member.username"></span>
                                        <template x-if="member.game?.name">
                                            <span class="text-xs text-slate-400 dark:text-slate-600" x-text="member.game.name"></span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
                <x-ui.buttons.redirectable
                    x-bind:href="getInviteLink()"
                    target="_blank"
                    class="mt-2 bg-indigo-500 border-indigo-700 hover:bg-indigo-400 dark:shadow-indigo-700/75 shadow-indigo-600/75 py-2 text-white"
                >
                    {{ __('Join Discord') }}
                </x-ui.buttons.redirectable>
            </div>
        </template>
    </div>
</div>
@endif
