<x-title-box
    title="Research Results ({{ $questions->total() }} results found)"
    icon="added-recent-questions"
/>

<div class="flex flex-col divide-y dark:divide-slate-800">
    @forelse ($questions as $question)
        <a
            href="{{ route('support.questions.show', [$question->id, $question->slug]) }}"
            class="hover:underline py-3 text-blue-500 text-sm hover:text-blue-700"
        >
            <i class="fa-regular fa-circle-question mr-1 text-xs"></i>
            {{ $question->title }}
        </a>
    @empty
    <span class="text-slate-400 dark:text-slate-500">
        No questions found for this search.
    </span>
    @endforelse
</div>

{{ $questions->withQueryString()->links() }}