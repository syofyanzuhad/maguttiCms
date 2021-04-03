<?php

namespace App\maguttiCms\Domain\Store\Controllers;


use Auth;
use Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use App\maguttiCms\Definition\Definition;
use App\maguttiCms\Domain\Store\Cart\CartVieModel;
use App\maguttiCms\Tools\StoreHelper;
use App\maguttiCms\Website\Requests\WebsiteFormRequest;

class MainStoreController extends Controller
{
    public function __construct() {}

    public function orderSubmit() {
	    if (!auth_user()){
            return Redirect::to(url_locale('/order-login'));
        }

        $cart = new CartVieModel();
        if (!$cart) {
            session()->flash('error', trans('store.alerts.cart_invalid'));
            return back();
        }
        if ($cart->isEmpty()) {
            session()->flash('error', trans('store.alerts.cart_empty'));
            return back();
        }
        return redirect(url_locale('cart/'.Definition::CART_STEP_ADDRESS));;

    }

	public function orderLogin()
	{
		$redirectTo = 'cart/'.Definition::CART_STEP_ADDRESS;
		$with_register = true;
		return view('magutti_store::login', compact('redirectTo', 'with_register'));
	}

	public function orderCreate(WebsiteFormRequest $request)
	{
		$user = Auth::user();

		$cart = StoreHelper::getSessionCart();

		StoreHelper::cartItemCleanQuantities($cart);

		if (!$cart || $request->cart_id != $cart->id) {
			session()->flash('error', trans('store.alerts.cart_invalid'));
			return back();
		}

		if (!$cart->cart_items->count()) {
			session()->flash('error', trans('store.alerts.cart_empty'));
			return back();
		}

		$billing_address_id = $request->billing_address_id;
		if (StoreHelper::isShippingEnabled()) {
			if ($request->shipping_address_id)
				$shipping_address_id = $request->shipping_address_id;
			else
				$shipping_address_id = $billing_address_id;
		}
		else
			$shipping_address_id = 0;

		$discount_code = $request->discount_code;

		$order = StoreHelper::orderCreate($cart, $billing_address_id, $shipping_address_id, $discount_code);

		if ($order) {
			StoreHelper::forgetSessionCart();
			session()->flash('success', trans('store.alerts.order_success'));
			return Redirect::to('/order-review/'.$order->token);
		}
		else {
			session()->flash('error', trans('store.alerts.order_fail'));
			return back();
		}
	}

	public function orderReview($token)
	{
		$order = StoreHelper::getOrderByToken($token);

		if ($order) {
			$order_items = $order->order_items()->list()->get();

			$payment_methods = StoreHelper::getPaymentMethods();

			return view('website.store.order_review', compact('order', 'order_items', 'payment_methods'));
		}
		else {
			return Redirect::to('/');
		}
	}

	public function orderPayment(WebsiteFormRequest $request)
	{
		$order_id = $request->order_id;
		$payment_method_id = $request->payment_method_id;
		$payment = StoreHelper::createPayment($order_id, $payment_method_id);

		if (!$payment) {
			session()->flash('error', );
			return back();
		}
		$response = StoreHelper::processPayment($payment);
		if ($response['status'] == 'ok') {
			return redirect($response['text']);
		}
		else {
			$order = $payment->order;
			session()->flash('error', $response['text']);
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
	}



	public function orderConfirm(Request $request, $token)
	{
		$order = StoreHelper::getOrderByToken($token);
		if (!$order) {
			session()->flash('error', trans('store.alerts.payment_fail'));
			return Redirect::to('/');
		}
		$payment = $order->payment;
		if ($payment->is_paid) {
			session()->flash('error', trans('store.alerts.payment_already_paid'));
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
		$response = StoreHelper::confirmPayment($payment, $request);
		dd($response);
		if ($response) {
			session()->flash('error', $response);
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
		else {
			session()->flash('success', trans('store.alerts.payment_success'));
			return Redirect::to(url_locale('/order-payment-result/'.$order->token));
		}
	}


}