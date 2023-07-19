<div class="ratings flex flex-col items-center" data-turbolinks-scroll>
    <span class="text-xss block text-black font-semibold">{{ __('Average rating: :n', ['n' => $user->profileRating->rating_avg]) }}</span>
    <div class="stars max-w-full overflow-hidden" style="--baseRatedCalculation: {{ $user->profileRating->rating_avg }}">
        @for ($i = 1; $i <= 5; $i++)
            <span class="star" data-rating="{{ $i }}" @click="ratingStore.evaluateHome"></span>
        @endfor
        <span class="star"></span>
    </div>
    <div class="mt-2 flex flex-col items-center">
        <span class="text-xss block text-black">{{ __(':n votes total', ['n' => $user->profileRating->total]) }}</span>
        <span class="text-xss block text-black">{{ __('(:n users voted 4 or better)', ['n' => $user->profileRating->most_posit]) }}</span>
    </div>
</div>
