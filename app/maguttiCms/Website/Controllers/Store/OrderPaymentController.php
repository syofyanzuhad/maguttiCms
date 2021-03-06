<?php


namespace App\maguttiCms\Website\Controllers\Store;


use App\Cart;
use App\Country;

use App\maguttiCms\Domain\Store\Action\UpdateCartAddressAction;
use App\maguttiCms\Tools\StoreHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class OrderPaymentController extends  CartStepController
{

    public function __construct()
    {

    }

    public function orderPaymentConfirm(Request $request)
    {

        $response = StoreHelper::confirmPayment('paypal', $request);

        if (!is_object($response)) {
            session()->flash('error', $response);

            $cart = StoreHelper::getSessionCart();
            return Redirect::to(url_locale('/order-payment-cancel/'.$cart->token));
        }
        else {

            session()->flash('success', trans('store.alerts.payment_success'));
            return Redirect::to(url_locale('/order-confirm/'.$response->token));
        }

    }

    public function cancel(Cart $cart)
    {

        if(optional($cart)->hasStep()) {
            session()->flash('message', trans('store.alerts.payment_cancel'));
            $countries = Country::list()->get();
            $payment_methods = StoreHelper::getPaymentMethods();
            return view('website.store.step_corfirm_order', compact('cart', 'countries', 'payment_methods'));
        }
        return $this->handleMissingStep();
    }
}
