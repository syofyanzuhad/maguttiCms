<?php

namespace App\maguttiCms\Middleware;

use Auth;
use Closure;
use App\maguttiCms\Domain\Store\Facades\StoreHelper;
use App\maguttiCms\Domain\Store\Facades\StoreFeatures;

class UserCart
{
    public function __construct() {}

    public function handle($request, Closure $next) {
		if (Auth::user()) {
			$cart = StoreHelper::getUserCart();
			if ($cart)
				StoreHelper::setSessionCart($cart);
		}
		return $next($request);
    }
}
