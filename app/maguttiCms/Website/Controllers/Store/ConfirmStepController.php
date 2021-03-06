<?php


namespace App\maguttiCms\Website\Controllers\Store;


use App\Cart;
use App\Country;

use App\maguttiCms\Domain\Store\Action\UpdateCartAddressAction;
use App\maguttiCms\Tools\StoreHelper;
use Illuminate\Support\Facades\Redirect;


class ConfirmStepController extends  CartStepController
{

    public function __construct()
    {

    }

    public function view()
    {
        $cart = $this->getCart();
        if(optional($cart)->hasStep()) {
            $countries = Country::list()->get();
            $payment_methods = StoreHelper::getPaymentMethods();
            return view('website.store.step_corfirm_order', compact('cart', 'countries', 'payment_methods'));
        }
        return $this->handleMissingStep();

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
