<?php
/*
|--------------------------------------------------------------------------
|  Store Options
|--------------------------------------------------------------------------
*/


use App\maguttiCms\Domain\Store\Features;

return [
	
	// enables store functionality
	'enabled' => true,
	// show prices to registered users only
	'private_prices' => false,

	// vat
	'vat' => [
		'apply_to_products' => true,
		'apply_to_shipping' => true,
		'percentage' => 0.22,
	],

	'shipping' => [
		'enabled' =>true,
	    'use_service' => false,
	],

	//------------//
	// formatting //
	//------------//

	'cart' => [
		'icon' => 'shopping-cart'
	],

	'formatting' => [
		'decimals' => 2,
		'decimal_separator' => ',',
		'thousands_separator' => '',
		'prepend_currency' => 1,
		'append_currency' => 0,
	],

	'discount' => [
		'apply_to_shipping' => false
	],

	// currency
	'currency' => 'EUR',
	'currency_symbol' => '€',

    'features' =>[
        Features::showPrice(),
        Features::shopBanner(),
    ]
];
