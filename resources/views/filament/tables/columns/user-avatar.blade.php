{{-- Styled in public/assets/css/filament.css: Filament 4 no longer compiles
     Tailwind utilities used in application-owned panel views. --}}
<div class="orion-user-avatar">
    <img loading="lazy" src="{{ $column->getAvatarUrl() }}" alt="{{ $column->getRecord()->name }}" />
</div>
