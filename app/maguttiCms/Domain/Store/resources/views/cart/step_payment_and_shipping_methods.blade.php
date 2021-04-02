@extends('website.app')
@section('content')
    <x-website.partials.page-header :title="trans('store.cart.title')"/>
    <section>
        <div class="container ">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card order-info box-shadow p-2">
                        @include('website.store.cart_step')
                        <h2 class="order-step-title">2. {{ trans('store.cart.step.shipping_and_payment') }}</h2>
                        <form class="mb-4 pl-3" action="{{url_locale('/cart/payment')}}" method="post">
                            {{ csrf_field() }}
                            <x-magutti_store-shipping-method-component :cart="$cart"/>
                            <x-magutti_store-payment-method-component  :cart="$cart"/>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-accent ">
                                    {{trans('store.cart.step.next_confirm')}}
                                </button>
                            </div>
                        </form>
                        <h2 class="order-step-title">3. {{ trans('store.cart.confirm') }}</h2>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    @include('website.store.cart_products_widget')
                </div>
            </div>

        </div>
    </section>
@endsection


