@if (Session::has('message'))
    <div class="flash alert alert-danger {{ Session::has('message_important') ? 'alert-important':''}} pf25 mb15">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('message') }}
    </div>
@endif

<div class="cart-resume no-border d-flex justify-content-between">
    <h2 class="cart-resume-title text-primary">1. {{trans('store.order.addresses')}}</h2>
    <a href="{{url_locale('/cart/address')}}" class="cart-resume-edit">
        {{trans('store.cart.edit_address')}}
    </a>
</div>
@if(last(request()->segments())!='payment')
    <div class="cart-resume d-flex justify-content-between">
        <h2 class="cart-resume-title text-primary">2. {{ trans('store.payment.method') }}</h2>
        <a href="{{url_locale('/cart/payment')}}" class="cart-resume-edit">
            {{trans('store.cart.edit_payment_method')}}
        </a>
    </div>
@endif




