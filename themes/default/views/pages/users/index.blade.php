@section('title', \Auth::user()->username)

<x-container class="relative h-auto !px-0">
    <div class="flex flex-col-reverse lg:flex-row gap-8 lg:gap-0">
        <div class="w-full lg:w-2/3 h-auto flex flex-col lg:pr-8 gap-6">
            <div>
                @include('pages.users.fragments.user.stories')
            </div>
            <div>
                @include('pages.users.fragments.user.online-friends')
            </div>
            <div>
                @include('pages.users.fragments.user.referrals')
            </div>
        </div>
        <div class="w-full h-auto lg:w-1/3 flex flex-col">
            @include('pages.users.fragments.latest-articles')
            <div class="mt-8">
                @include('pages.users.fragments.discord-widget')
            </div>
        </div>
    </div>
</x-container>
