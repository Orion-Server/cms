@extends('layouts.app')

@section('title', __('Shop'))

@section('content')
<section
    x-data="shopComponent('{{ route('shop.products.buy', ['productId' => '%ID%']) }}')"
>
    <div class="bg-[#E77307] bg-[url('https://i.imgur.com/U47gQYh.png')] -mt-4 pb-10 shadow-[inset_0_0_0_15px_rgba(0,0,0,0.1),0_4px_0_rgba(0,0,0,0.1)] relative">
        <div class="bg-[url('https://i.imgur.com/ngpWiI8.png')] bg-repeat-x w-full h-[85px]"></div>
        <x-container class="mt-4">
            <div class="my-6">
                <x-title-box
                    icon="featured-products"
                    title="{{ __('Featured Products') }}"
                    description="{{ __('Featured products will appear below. Take the opportunity!') }}"
                    title-classes="text-white font-bold"
                    description-classes="text-slate-100"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($featuredProducts as $product)
                    <x-shop.product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center">
                        <span class="text-slate-100 font-bold mt-4">{{ __('No featured products found.') }}</span>
                    </div>
                @endforelse
            </div>
        </x-container>

        <x-ui.modal x-if="product" type="view-shop-product" />
    </div>

    <x-container class="flex gap-4 mt-6">
        <div class="w-1/4 flex flex-col">
            <x-title-box
                icon="categories"
                title="{{ __('Categories') }}"
            />

            <div class="mt-6 flex flex-col gap-2">
                @if($currentCategoryId)
                <x-ui.buttons.redirectable
                    href="{{ route('shop.index') }}"
                    class="!justify-start hover:ml-2 hover:!text-blue-400 transition-[margin-left] dark:text-slate-200 border-none bg-white dark:bg-slate-950 shadow py-3"
                >
                    <i class="fas fa-chevron-left mr-2"></i>
                    {{ __('Show all') }}
                </x-ui.buttons.redirectable>
                @endif

                @foreach($categories as $category)
                <x-ui.buttons.redirectable
                    href="{{ route('shop.categories.show', $category->id) }}#products"
                    @class([
                        "!justify-start dark:text-slate-200 border-none bg-white dark:bg-slate-950 shadow py-3",
                        "!bg-blue-400 !text-white" => $currentCategoryId == $category->id,
                        "hover:ml-2 hover:!text-blue-400 transition-all" => $currentCategoryId != $category->id,
                    ])
                >
                    <img src="{{ $category->icon }}" label="{{ $category->name }}" class="mr-2" />
                    {{ $category->name }}
                </x-ui.buttons.redirectable>
                @endforeach

                <div class="flex flex-col gap-6 mt-6">
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
            </div>
        </div>
        <div class="w-3/4 flex flex-col gap-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4" id="products">
                @forelse($products as $product)
                    <x-shop.product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center">
                        <span class="text-slate-100 font-bold mt-4">{{ __('No featured products found.') }}</span>
                    </div>
                @endforelse
            </div>
            {{ $products->links() }}
        </div>
    </x-container>

    @if(session()->has('shopError'))
        @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                window.notyf.error("{{ session()->get('shopError') }}", 5000)
            });
        </script>
        @endpushOnce
    @enderror

    @if(session()->has('shopSuccess'))
        @pushOnce('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                window.notyf.success("{{ session()->get('shopSuccess') }}", 5000)
            });
        </script>
        @endpushOnce
    @enderror
</section>
@endsection
