@extends('layouts.app')

@section('title', __('My purchases'))

@section('content')
<x-container>
    <x-title-box icon="story-camera" title="{{ __('My Purchases') }}" />

    <div class="bg-white p-2 rounded-lg shadow dark:bg-slate-950 mt-4">
        <table class="border-collapse table-fixed w-full text-sm">
            <thead>
                <tr class="py-2 bg-blue-500">
                    <th class="border-b rounded-tl-lg dark:border-slate-600 font-medium p-4 text-center text-slate-200 dark:text-slate-200">{{ __('Status') }}</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 text-center text-slate-200 dark:text-slate-200">{{ __('Product Name') }}</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 text-center text-slate-200 dark:text-slate-200">{{ __('Price') }}</th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 text-center text-slate-200 dark:text-slate-200">{{ __('Created At') }}</th>
                    <th class="border-b rounded-tr-lg dark:border-slate-600 font-medium p-4 text-center text-slate-200 dark:text-slate-200">{{ __('Is Delivered?') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
                @forelse ($purchases as $purchase)
                    <tr>
                        <td class="border-b border-slate-100 text-center dark:border-slate-700 p-4 text-slate-700 dark:text-slate-400">
                            <span @class([
                                "px-2 py-1 rounded-lg border font-medium text-sm text-slate-100",
                                "bg-green-500 border-green-600" => $purchase->status->value === 'completed',
                                "bg-yellow-500 border-yellow-600" => $purchase->status->value === 'pending',
                                "bg-red-500 border-red-600" => $purchase->status->value === 'cancelled'
                            ])>{{ __(ucfirst($purchase->status->value)) }}</span>
                        </td>
                        <td class="border-b border-slate-100 text-center dark:border-slate-700 p-4 text-slate-700 dark:text-slate-400">{{ $purchase->product->name }}</td>
                        <td class="border-b border-slate-100 text-center dark:border-slate-700 p-4 text-slate-700 dark:text-slate-400">{{ $purchase->product->formatted_price }}</td>
                        <td class="border-b border-slate-100 text-center dark:border-slate-700 p-4 text-slate-700 dark:text-slate-400">{{ $purchase->created_at->diffForHumans() }}</td>
                        <td class="border-b border-slate-100 text-center dark:border-slate-700 p-4 text-slate-700 dark:text-slate-400">
                            @if ($purchase->is_delivered)
                                <span class="px-2 py-1 rounded-lg border font-medium text-sm text-slate-100 bg-green-500 border-green-600">{{ __('Yes') }}</span>
                            @else
                                <span class="px-2 py-1 rounded-lg border font-medium text-sm text-slate-100 bg-red-500 border-red-600">{{ __('No') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="rounded-b-lg text-center p-4 text-slate-700 dark:text-slate-400">{{ __('No purchases found.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-2 mt-4">
        {{ $purchases->links() }}
    </div>
</x-container>
@endsection
