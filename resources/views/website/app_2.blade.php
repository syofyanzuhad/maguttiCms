@inject('pages','App\Article')
<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="{!! LaravelLocalization::getCurrentLocale() !!}" lang="{!! LaravelLocalization::getCurrentLocale() !!}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="marcoax" />
    <meta name="google-site-verification" content="" />

    <link rel="image_src" href="{!! asset(config('maguttiCms.admin.path.assets').'website/images/logo.jpg') !!}"/>
    <!-- Meta SEO -->
    {!! SEO::generate() !!}
    <meta property="og:url" content="{!! rtrim(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale()), '/') !!}" />
    <!-- ./Meta SEO -->
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{$localeCode}}" href="{{ rtrim(LaravelLocalization::getLocalizedURL($localeCode), '/') }}"/>
    @endforeach

    @if(isset($article) && $article->seo_no_index )
        <meta name="robots" content="noindex">
    @endif
    <link href="{!! LaravelLocalization::getLocalizedURL( LaravelLocalization::getCurrentLocale() )!!}/" rel="canonical" />
    <link rel="icon" href="{!! asset('/favicon.ico') !!}" type="any" sizes="16x16">
    <link rel="stylesheet" href="{!! mix('website/css/helper.css')!!}">
    <link rel="stylesheet" href="{!! mix('website/css/app.css')!!}">
    <link rel="stylesheet" href="{!! asset(config('maguttiCms.admin.path.assets').'website/css/lib/maCookieEu.css')!!}">
    <!-- Owl Carousel Assets -->
    <link href="{!! asset(config('maguttiCms.admin.path.assets').'website/plugins/owl-carousel/owl.carousel.css')!!}" rel="stylesheet">
    <link href="{!! asset(config('maguttiCms.admin.path.assets').'website/plugins/owl-carousel/owl.theme.default.css')!!}" rel="stylesheet">
    <!-- Color box -->
    <link href="{!! asset(config('maguttiCms.admin.path.assets').'website/plugins/colorbox/colorbox.css')!!}" rel="stylesheet">
     <!-- GA -->
    @include('website.partials.widgets_ga')
</head>
<body>
    @include('website.partials.navbar')
    @yield('content')
        <div class="bck-color-main">
            <div class="container bck-color-main">
                <div class="row">
                    <div class=" col-sm-12 col-xs-12 col-md-6 pt20" id="foot-dx-bottom">
                        @include('website.partials.widgets_newsletter')
                    </div>
                    <div class=" col-sm-12 col-xs-12 col-md-6 pt5" id="foot-dx-bottom">
                        @include('website.partials.social')
                    </div>
                </div>
            </div>
        </div>
    @section('footer')
        <footer class="bck-color-footer pf15">
            <div class="container">
                <div class="row">
                    <div  class="mf0 color-5">
                        <strong>{!! config('maguttiCms.website.option.app.name')!!}</strong>
                        {!! config('maguttiCms.website.option.app.address')!!}- {!! config('maguttiCms.website.option.app.locality')!!} | T. {!! config('maguttiCms.website.option.app.phone')!!} - F. {!! config('maguttiCms.website.option.app.fax') !!} -
                        <a class="color-5" href="mailto:{!! config('maguttiCms.website.option.app.email') !!}">{!! config('maguttiCms.website.option.app.email') !!}</a>
                    </div>
                    <div  class="mf0 color-5">
                        Copyright © <?php echo date('Y'); ?> {!! config('maguttiCms.website.option.app.name')!!} | P.IVA {!! config('maguttiCms.website.option.app.vat')!!} | All Rights Reserved. |
                        <a class="color-5" href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( 'privacy' )) }}">{{ trans('website.privacy')}}</a> |
                        <a class="color-5" href="{{ Setting::getOption('credits_url') }}" target="_blank">Credits</a>
                    </div>
                </div>
            </div>
        </footer>
    @show

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
<script type="text/javascript">

    var urlAjaxHandler  = "{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(),URL::to( '' )) }}";
    var _LANG           = "{{ LaravelLocalization::getCurrentLocale()}} ";
    var _WEBSITE_NAME	= "{!! config('maguttiCms.website.option.app.name')!!}";
    var imageScroll     = "{!! asset(config('maguttiCms.admin.path.assets').'website/images/up.png') !!}";
</script>


<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="{!! mix('website/js/botomera.js')!!}"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/plugins/carousel-swipe.js')!!}"></script>
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/plugins//wow-animations/js/wow.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/plugins/owl-carousel/owl.carousel.min.js')!!}"></script>
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/plugins/colorbox/jquery.colorbox.js')!!}"></script>
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.plugins').'bootbox.js') !!}"></script>
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/js/app.js')!!}"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="{!! asset(config('maguttiCms.admin.path.assets').'/website/plugins/back-to-top.js')!!}"></script>

@yield('footerjs')
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
        App.initWoW();
        App.iniServiceOwl();
        App.initTouchBTSlider('#myCarousel');
        App.initColorBox()
    });
</script>

@include('website.partials.widgets_cookie')
</body>
</html>