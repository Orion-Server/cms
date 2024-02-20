<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\WriteableBox;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public const ENABLE_ERRORS_LOG = true;
    private const PRODUCTS_LIST_LIMIT = 12;

    public function index(?string $currentCategoryId = null): View
    {
        $categories = ShopCategory::visible()->get();
        $products = ShopProduct::latest()->active(considerRank: false);
        $featuredProducts = ShopProduct::active()->featured()->get();
        $writeableBoxes = WriteableBox::getForPage('shop');

        if($currentCategoryId) {
            $products->whereCategoryId($currentCategoryId);
        }

        $products = $products->paginate(self::PRODUCTS_LIST_LIMIT)->fragment('products');

        return view('pages.shop.index', compact('categories', 'featuredProducts', 'products', 'currentCategoryId', 'writeableBoxes'));
    }

    public function makePaymentOrder(string $productId, PayPal $paypal)
    {
        $product = ShopProduct::find($productId);

        if(!$product) {
            return $this->index();
        }

        $user = Auth::user();

        if($user->online) {
            return redirect()->route('shop.index')->with('shopError', __('You must be offline to buy!'));
        }

        $orderDetail = $paypal->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'brand_name' => getSetting('hotel_name'),
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'CONTINUE',
                'landing_page' => 'BILLING',
                'return_url' => route('shop.payment.sucessfull'),
                'cancel_url' => route('shop.payment.cancelled')
            ],
            'purchase_units' => [
                [
                    'description' => $product->name,
                    'reference_id' => $product->id,
                    'amount' => [
                        'value' => $product->price,
                        'currency_code' => config('paypal.currency')
                    ]
                ]
            ]
        ]);

        if(!array_key_exists('id', $orderDetail)) {
            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[PROCESS] PayPal order id is not available.', [
                    'user' => $user->username,
                    'orderDetail' => $orderDetail,
                ]);
            }

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        $approveLink = collect($orderDetail['links'])->where('rel', 'approve')->first();

        if(!count($approveLink)) {
            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[PROCESS] PayPal approve link is not available.', [
                    'user' => $user->username,
                    'orderDetail' => $orderDetail,
                ]);
            }

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        Auth::user()->orders()->create([
            'order_id' => $orderDetail['id'],
            'product_id' => $product->id,
            'price' => $product->price
        ]);

        return redirect()->away($approveLink['href']);
    }

    public function paymentSucessfull(Request $request, PayPal $paypal): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();

        $order = $user->orders()
            ->completeRelationships()
            ->where('order_id', $request->token)
            ->first();

        if(!$order) {
            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[SUCESSFULL] PayPal order not found.', [
                    'user' => $user->username,
                    'order' => $order->product->name,
                ]);
            }

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        $paymentOrder = $paypal->capturePaymentOrder($request->token);

        if(!array_key_exists('status', $paymentOrder)) {
            $firstError = $paymentOrder['error']['details'][0];

            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[SUCESSFULL] PayPal payment order status is not available.', [
                    'user' => $user->username,
                    'order' => $order->product->name,
                    'paymentOrder' => $paymentOrder
                ]);
            }

            $order->update([
                'details' => $firstError['description']
            ]);

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        if($paymentOrder['status'] !== 'COMPLETED') {
            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[SUCESSFULL] PayPal payment order status is not completed.', [
                    'user' => $user->username,
                    'order' => $order->product->name,
                    'paymentOrder' => $paymentOrder
                ]);
            }

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        $purchaseDetails = $paymentOrder['purchase_units'][0];

        if($purchaseDetails['reference_id'] != $order->product_id) {
            if(self::ENABLE_ERRORS_LOG) {
                Log::driver('shop')->error('[SUCESSFULL] PayPal payment order reference id does not match with the order product id.', [
                    'user' => $user->username,
                    'order' => $order->product->name,
                    'purchaseDetails' => $purchaseDetails
                ]);
            }

            return redirect()->route('shop.index')->with('shopError', __('Something went wrong, please try again later'));
        }

        $paymentDetails = $purchaseDetails['payments']['captures'][0];

        $order->update([
            'status' => 'completed',
            'price' => $paymentDetails['amount']['value'],
            'currency' => $paymentDetails['amount']['currency_code'],
            'paypal_fee' => $paymentDetails['seller_receivable_breakdown']['paypal_fee']['value'],
        ]);

        ShopService::deliver(Auth::user(), $order);

        $order->product->increment('sales_count');

        return redirect()->route('shop.index')
            ->with('shopSuccess', __('Payment completed. Thanks for your purchase!'));
    }

    public function paymentCancelled(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $order = Auth::user()->orders()->where('order_id', $request->token)->first();

        if($order) {
            $order->update([
                'status' => 'cancelled'
            ]);
        }

        return redirect()->route('shop.index')
            ->with('shopError', __('Payment cancelled.'));
    }
}
