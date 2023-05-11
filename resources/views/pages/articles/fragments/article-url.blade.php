@props([
    'article' => null,
    'isActive' => false
])

<a
    href="{{ route('articles.show', [$article->id, $article->slug]) }}"
    data-tippy-singleton
    data-tippy-content="<small>Posted by <b>{{ $article->user->username }}</b></small>"
    @class([
        "dark:text-slate-300 text-sm py-1.5 border-l border-slate-300 dark:border-slate-600 pl-3 decoration-slate-400 hover:!text-blue-400",
        "!border-blue-400 !text-blue-400 border-l-2" => $isActive,
        "hover:!border-slate-400" => !$isActive,
        "!border-lime-400" => !$isActive && $article->is_promotion && $article->promotion_ends_at->gt(now())
    ])
>
    {{ $article->title }} <span @class([
        "!text-blue-400" => $isActive,
        "text-lime-400" => !$isActive && $article->is_promotion && $article->promotion_ends_at->gt(now())
    ])">»</span>
</a>
