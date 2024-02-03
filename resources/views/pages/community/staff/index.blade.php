@extends('layouts.app')

@section('title', __('Staff Team'))

@section('content')
    <x-container class="flex justify-between flex-col lg:flex-row gap-6" x-data="staff">
        <div class="w-full lg:w-1/4 h-auto flex flex-col gap-4">
            @foreach($writeableBoxes as $box)
            <div>
                <x-title-box
                    image="{{ $box->icon }}"
                    :image-is-badge="true"
                    title="{{ $box->name }}"
                    description="{{ $box->description }}"
                />
                <div class="mt-4 p-4 prose dark:prose-invert text-xs font-medium dark:text-slate-200 bg-white dark:bg-slate-950 rounded-lg border-b-2 border-gray-300 dark:border-slate-800 shadow-lg">
                    {!! $box->content !!}
                </div>
            </div>
            @endforeach
        </div>
        <div class="w-full lg:w-3/4 flex flex-col gap-4">
            <div class="w-full h-auto flex lg:flex-row flex-wrap gap-2">
                <x-ui.buttons.default
                    class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                    id="staff-tab-button"
                    disabled
                    @click="changeTab($event, '0')"
                >
                    {{ __('All') }}
                </x-ui.buttons.default>
                @foreach ($staffs as $staff)
                <x-ui.buttons.default
                    class="dark:bg-blue-500 bg-blue-500 border-blue-700 hover:bg-blue-400 dark:hover:bg-blue-400 dark:shadow-blue-700/75 shadow-blue-600/75 py-2 text-white"
                    id="staff-tab-button"
                    @click="changeTab($event, {{ $staff->id }})"
                >
                    {{ $staff->name }}
                </x-ui.buttons.default>
                @endforeach
            </div>
            <div class="flex flex-col gap-8">
                @foreach ($staffs as $staff)
                    <div class="w-full rounded-lg shadow-lg"
                        x-transition
                        x-transition:enter.delay.300ms
                        x-show="isTab({{ $staff->id }})"
                    >
                        <div class="w-full bg-gray-200 dark:bg-slate-850 dark:border-gray-700 border-b border-gray-300 flex p-2 rounded-t-lg">
                            <x-title-box
                                image="{{ $staff->getBadgePath() }}"
                                :image-is-badge="true"
                                :small="true"
                                title="{{ $staff->name }}"
                                description="{{ $staff->description }}"
                            />
                        </div>
                        <div class="w-full grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 bg-white dark:bg-slate-800 h-auto rounded-b-lg p-2">
                            @forelse ($staff->users as $userStaff)
                                <div class="w-full h-auto flex flex-col border-b-2 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 rounded-lg">
                                    <div class="w-full overflow-hidden bg-slate-500 dark:bg-slate-850 border-b dark:border-slate-700 relative flex items-center justify-start p-2 h-10 bg-center bg-no-repeat rounded-t-md">
                                        <div class="w-full flex gap-2 justify-start items-center">
                                            <div @class([
                                                "w-3 h-3 rounded-full",
                                                "bg-green-400 animate-pulse" => $userStaff->online,
                                                "bg-red-500" => ! $userStaff->online,
                                            ])></div>
                                            <a href="{{ route('users.profile.show', $userStaff->username) }}" class="text-white font-bold truncate text-sm hover:underline underline-offset-4">{{ $userStaff->username }}</a>
                                        </div>
                                        <div
                                            class="absolute -bottom-12 right-0 w-[64px] h-[110px] bg-center bg-no-repeat"
                                            style="background-image: url('{{ getFigureUrl($userStaff->look, 'direction=3&head_direction=2&size=m&gesture=sml') }}')"
                                        ></div>
                                    </div>
                                    <div class="w-full h-auto flex flex-col p-1 pl-2">
                                        <div class="flex-1 flex gap-0.5 text-slate-800 dark:text-slate-200 min-h-[48px] flex-wrap">
                                            @foreach ($userStaff->activeBadges as $activeBadge)
                                                <div
                                                    class="w-[48px] h-[48px] bg-white border dark:border-none rounded-lg dark:bg-slate-800 bg-center bg-no-repeat"
                                                    style="background-image: url('{{ $activeBadge->getBadgePath() }}')"
                                                    data-tippy
                                                    data-tippy-content="<small><b>{{ $activeBadge->badge_code }}</b></small>"
                                                ></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @empty
                            <span
                                class="text-slate-600 dark:text-slate-400 col-span-full font-medium text-sm text-center p-2"
                            >
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                {{ __('No staffs found for this rank.') }}
                            </span>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-container>
@endsection
