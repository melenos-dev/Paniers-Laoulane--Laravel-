<!doctype html>
<html lang="{{Lang::locale()}}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
      <meta http-equiv="X-UA-Compatible" content="IE-edge">
      @if (Str::startsWith($current = url()->current(), 'https://www.'))
      <link rel="canonical" href="{{ str_replace('https://www.', 'https://', $current) }}">
      @else
      <link rel="canonical" href="{{ str_replace('https://', 'https://www.', $current) }}">
      @endif
      <meta name="keywords" content="">
      @yield('meta')
      <meta property="og:locale" content="{{Lang::locale()}}" />
      @foreach(localization()->getSupportedLocales() as $key => $locale)
          <meta property="og:locale:alternate"content="{{ $key }}" />
      @endforeach
      <meta property="og:url" content="{{ url()->current() }}">
      <meta property="og:title" content="@yield('title')">
      <meta property="og:site_name" content="Les paniers de Laoul'ane ! @lang('Local producers in Morbihan, Brittany')">
      <link rel="icon" type="image/vnd.microsoft.icon" href="{{asset('img/logo/favicon.ico')}}">
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/logo/favicon.ico')}}">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      {!! Html::style('https://necolas.github.io/normalize.css/8.0.1/normalize.css') !!}
      {!! Html::style('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css') !!}
      {!! Html::style('https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css') !!}
      {!! Html::style(asset('css/app.css')) !!}
      {!! Html::script("https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js") !!}
      {!! Html::script("https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js") !!}
      {!! Html::script("https://code.jquery.com/jquery-3.6.0.min.js") !!}
      {!! Html::script("https://kit.fontawesome.com/0fa5ab23a2.js") !!}

      <!--[if It IE 9]>
          {!! Html::script('https://oss.maxcdn.com/libs/3.3.6/html5shiv/3.7.2/html5shiv.js') !!}
          {!! Html::script('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') !!}
      <![endif]-->
      <style>
          textarea { resize:none; }
      </style>

      <title>@yield('title')</title>
      <!-- Scripts -->
      @yield('scripts')
      <script src="{{ asset('js/search.js') }}" defer></script>
  </head>

  <body>
    @include('auth.login')
    <nav class="navbar navbar-expand navbar-light">
      <div class="container-xxl">
        <ul class="navbar-nav menu">
        <li class="nav-item bars">
        <button type="button" data-bs-toggle="collapse" data-bs-target="#Menu" aria-controls="Menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa-solid fa-bars"></i>
        </button>
        </li>
          <div class="dropdown collapse" id="Menu" aria-labelledby="Menu">

            <li class="nav-item {{ (request()->routeIs('welcome')) ? 'active' : '' }}">
              <a href="{{ route('welcome') }}" class="nav-link">@lang('Home')</a>
            </li> 

            <li class="nav-item {{ (request()->routeIs('user.index')) ? 'active' : '' }}">
              <a href="{{ route('user.index') }}" class="nav-link">@lang('My account')</a>
            </li> 

            <li class="nav-item {{ (request()->routeIs('who')) ? 'active' : '' }}">
              <a href="{{ route('who') }}" class="nav-link">@lang('About us')</a>
            </li>

            <li class="nav-item {{ (request()->routeIs('contact')) ? 'active' : '' }}">
              <a href="{{ route('contact') }}" class="nav-link">Contact</a>
            </li>
          </div>
          @guest 
              <li class="nav-item user user-subscribe {{ (request()->routeIs('auth.register')) ? 'active' : '' }}">
                <a href="{{ route('auth.register') }}" class="nav-link">@lang('Subscribe')</a>
              </li>    

              <li data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="@lang('Log in')" class="nav-item user user-login rounded-pill {{ (request()->routeIs('log')) ? 'active' : '' }}">
                <a data-bs-toggle="modal" data-bs-target="#loginModal" href="#loginModal" class="nav-link login">@lang('Log in')</a>
              </li>
          @else
              <li class="nav-item logged">
                      <a class="nav-link" title="@lang('Logout')" onclick="
                        event.preventDefault(); document.getElementById('logout-form').submit();
                      "
                      href="{{ route('logout') }}"><i class="fa-solid fa-power-off"></i></a>


                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                      </form>
              </li>

              <li class="nav-item basket">
                <a href="{{ route('user.index') }}" class="nav-link"><i title="@lang('My basket')" class="fa-solid fa-basket-shopping"></i></a>
              </li>
          @endguest
          @foreach(localization()->getSupportedLocales() as $key => $locale)
            <li class="nav-item lang">
              <a class="flag-icon-{{($key == 'en') ? 'gb' : $key}} {{ (app()->getLocale() == $key) ? 'active' : '' }}" href=
              "{{ localization()->getLocalizedURL($key) }}"></a>
            </li>
          @endforeach
        </ul>
      </div>
    </nav>
    <header class="container-xxl py-2 pb-0">
      <div class="d-flex">
        <a class="navbar-brand" href="{{ route('welcome') }}" title="@lang('Home')">
            <div class="background"></div>
            <img src="{{URL::asset('/img/logo/les-paniers-de-laoulane.png')}}" alt="Les paniers de Laoulan !"/>
        </a>
        <div class="slogan">
          <h1>@Lang('Local food in Morbihan !')</h1>
          <p class="mb-0">"@lang('They consume intelligently for more green for their children')"</p>
        </div>
      </div>
      <form action="{{route('product.search')}}" method="POST" accept-charset="UTF-8" id="search" class="d-flex">
          {{ csrf_field() }}
          <input class="form-control" name="query" type="search" placeholder="@lang('Search a product') ..." aria-label="Search">
          <button class="btn btn__search btn-outline-success" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </header>
    <div class="container-xxl">

      @yield('ariane')
      
      <main class="row px-0 page">
        <svg
          xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
          xmlns:svg="http://www.w3.org/2000/svg"
          xmlns="http://www.w3.org/2000/svg"
          width="120.57616mm"
          height="130.60469mm"
          viewBox="0 0 444.95491 434.42607"
          sodipodi:docname="Stag.svg">
          <g
            inkscape:label="Layer 1"
            inkscape:groupmode="layer"
            id="layer1"
            transform="translate(1213.906,433.42226)">
            <path
              inkscape:connector-curvature="0"
              style="fill:#000000"
              d="m -1185.0181,0.29725637 c -3.3822,-0.5929 -14.3553,-4.59169997 -18.7427,-6.82999997 -3.1951,-1.63 -3.7573,-2.3628 -3.7573,-4.8977004 0,-3.6664 -1.5912,-2.4165 -2.0533,1.6127004 l -0.3225,2.8125 -2.2038,-4.1634004 c -2.1615,-4.0836 -2.183,-4.3801 -1.1223,-15.4687 4.0701,-42.5458 4.8964,-59.5866 2.8894,-59.5866 -0.5157,0 -0.9375,-1.0535 -0.9375,-2.341 0,-3.9818 7.7951,-11.2699 25.0834,-23.451996 3.9936,-2.814 5.9944,-8.4835 6.9173,-19.6009 0.9635,-11.6068 2.4819,-17.1502 5.9391,-21.6827 l 2.3408,-3.069 -5.3747,-5.4994 c -9.4937,-9.7138 -12.6443,-17.8655 -13.7171,-35.4907 -0.6238,-10.2492 0.7018,-13.6702 6.6889,-17.2626 2.1844,-1.3106 5.1908,-4.1003 6.681,-6.1992 2.5359,-3.5718 9.1114,-8.5863 15.6093,-11.9036 5.4468,-2.7807 21.8714,-8.0591 32.4415,-10.4257 26.4872,-5.9305 52.5673,-9.007 76.2967,-8.9998 17.5383,0.01 27.2483,0.9439 44.2939,4.2819 l 12.41883,2.432 12.89364,-2.5456 c 11.17049,-2.2053 14.33448,-2.4737 23.67489,-2.008 5.92969,0.2955 15.29996,1.2439 20.82282,2.1076 12.34112,1.9296 16.34759,1.4087 25.82667,-3.3581 17.3292,-8.7143 32.88029,-25.0458 37.86229,-39.7623 l 1.57326,-4.6472 -9.5269,-3.5776 c -11.7998,-4.4312 -16.06621,-7.3321 -20.47111,-13.9191 -4.25722,-6.3661 -5.04311,-9.2023 -3.23383,-11.6707 1.19583,-1.6316 2.38837,-1.8617 9.18243,-1.7724 7.06658,0.093 12.36842,1.3063 19.64164,4.4955 1.2333,0.5408 1.4343,0.2133 1.06258,-1.7313 -0.59622,-3.1188 0.34669,-3.0795 9.9202,0.4144 9.31574,3.3998 10.48618,3.4852 7.74206,0.5641 -1.36395,-1.4518 -3.66367,-2.4713 -6.49155,-2.8779 -47.12683,-6.775 -83.86402,-21.32691 -96.67367,-38.29311 -5.63318,-7.4611 -11.40274,-20.44704 -11.99722,-27.00298 -0.53745,-5.92706 1.34639,-12.71043 4.17977,-15.05062 1.37237,-1.13353 1.45183,-0.56578 0.88189,6.30084 -0.45674,5.50285 -0.30075,7.99191 0.576,9.19097 1.12061,1.53253 1.4776,1.44497 5.24973,-1.28756 2.22603,-1.6125 4.19408,-2.78513 4.37343,-2.60578 0.17936,0.17934 -0.4927,2.15494 -1.49344,4.39022 -2.23086,4.98272 -2.40974,12.51018 -0.34633,14.57362 2.04015,2.04009 2.33943,1.93539 5.83514,-2.04244 2.95847,-3.36637 3.03151,-3.39487 1.72099,-0.67068 -2.04936,4.25991 -2.70841,9.05391 -1.63338,11.88141 3.43351,9.0308 22.86348,20.6517 47.94208,28.6738 13.2409,4.2354 18.26039,4.76911 8.29585,0.8819 -14.08211,-5.4935 -21.94998,-10.5727 -32.28849,-20.8446 -8.41014,-8.3559 -9.96831,-10.4515 -14.33428,-19.27851 -5.58074,-11.283 -8.22088,-21.94369 -9.15605,-36.97144 -0.59859,-9.61894 0.25141,-15.25284 2.83323,-18.77897 1.20469,-1.64531 1.29501,-1.01766 0.83064,5.77266 -0.28657,4.19034 -0.22477,9.1979 0.13733,11.12803 l 0.65834,3.50925 4.85831,-0.61444 c 2.67208,-0.33797 6.83545,-1.57641 9.25195,-2.75203 3.58306,-1.74328 4.24109,-1.85259 3.56681,-0.59269 -0.45475,0.84966 -1.48267,2.08922 -2.28425,2.75447 -0.80159,0.66525 -1.45744,1.79925 -1.45744,2.51991 0,1.06772 1.60606,1.20768 8.67188,0.7559 7.7079,-0.49284 9.01056,-0.34012 11.71875,1.37353 3.77886,2.39129 4.03947,4.14235 0.46875,3.14963 -7.1839,-1.99725 -20.07584,0.87694 -24.15596,5.38547 -2.14749,2.3729 -3.68079,15.10406 -2.31683,19.23684 1.51263,4.58335 7.74011,13.82819 12.35724,18.34469 10.58425,10.3536 32.07427,21.4025 48.08525,24.7227 5.79298,1.2013 13.64253,3.4907 17.44343,5.08771 8.75578,3.6788 11.74141,3.6556 18.44482,-0.1433 l 5.37642,-3.04691 15.9375,0 c 9.3091,0 18.87691,0.5285 23.0051,1.2706 4.81573,0.8658 8.10149,0.9935 10.3125,0.4009 1.7847,-0.4784 4.24484,-0.6222 5.46698,-0.3196 1.78457,0.4419 0.89552,0.9775 -4.51548,2.72021 -7.4527,2.4004 -12.74489,2.3189 -29.84279,-0.4589 -9.55114,-1.55181 -14.61202,-0.98971 -22.49825,2.4988 -3.62654,1.6041 -4.09318,2.1289 -3.52415,3.9622 0.36074,1.1623 0.75649,2.8853 0.87944,3.8288 0.12806,0.9828 1.8232,2.4317 3.96889,3.3923 2.05994,0.9222 5.19432,2.9233 6.9653,4.4468 6.10749,5.2539 15.43101,11.2213 23.42298,14.9914 4.40854,2.0798 10.10385,5.2705 12.65625,7.0906 2.5524,1.8201 9.07042,5.4919 14.48448,8.1597 5.41406,2.6676 10.8695,5.8597 12.1232,7.0934 1.99707,1.9653 2.143,2.5426 1.17798,4.6606 -0.67333,1.4777 -2.8347,3.1829 -5.56069,4.3867 -3.91663,1.7297 -7.08299,2.0531 -26.02174,2.6579 -28.60643,0.9134 -30.46875,1.689 -30.46875,12.6896 0,5.6704 -3.3167,16.8043 -8.22832,27.6218 -5.70325,12.561 -15.23682,22.0305 -25.05254,24.884 -7.14074,2.0759 -12.4309,7.8125 -13.55101,14.6947 -1.02202,6.2796 -3.25824,10.8902 -8.49533,17.5156 l -3.89947,4.9332 3.23459,4.8717 c 1.77902,2.6794 5.08549,6.2484 7.34771,7.931 8.35621,6.2155 28.6263,19.1232 32.96772,20.9936 5.85294,2.5215 8.66507,6.4577 8.56506,11.9887 -0.0955,5.2814 -11.60128,50.377496 -15.37391,60.257096 -3.50429,9.1768 -7.69685,15.3506 -11.7306,17.2741 -5.30496,2.5299 -6.45375,1.3 -5.82222,-6.2329 0.56917,-6.789 1.59687,-9.2499 6.55181,-15.6883 6.46024,-8.3946 6.62262,-8.7687 6.81098,-15.6936 0.18045,-6.6337 0.59811,-7.9753 6.23833,-20.04 5.43282,-11.621096 3.85545,-20.004396 -4.49509,-23.889996 -3.29576,-1.5337 -21.82414,-10.9013 -46.40676,-23.4626 -8.84731,-4.5208 -15.96027,-6.2994 -18.43895,-4.6109 -1.5992,1.0895 -3.63784,12.2376 -5.3965,29.5104 -2.12217,20.842896 -3.9775,30.379996 -7.10638,36.529996 -3.90352,7.6725 -5.35557,14.1985 -6.08654,27.3548 -0.5779,10.4011 -0.43151,12.2571 1.45722,18.4753 3.74615,12.3334 6.08351,15.3678 13.1602,17.0845 1.28906,0.3128 3.94731,1.897 5.90722,3.5205 3.47341,2.8774 3.5208,2.9996 1.875,4.8352 -1.53517,1.7121 -2.44577,1.8301 -10.02938,1.299 -4.5875,-0.3214 -8.91685,-1.0622 -9.62079,-1.6464 -1.15106,-0.9554 -5.54414,-9.6073 -7.31546,-14.4075 -0.67046,-1.8169 -0.71708,-1.8096 -1.50528,0.2344 -2.29471,5.9509 -4.36618,-1.3023 -3.10378,-10.8679 1.089,-8.2515 0.65549,-53.5345 -0.62069,-64.835196 -0.55318,-4.8984 -2.03651,-12.8462 -3.2963,-17.6617 -2.6267,-10.0404 -3.00993,-20.8999 -0.97604,-27.6581 0.72297,-2.4022 1.15136,-4.3677 0.95198,-4.3677 -0.19939,0 -6.59169,1.2404 -14.20512,2.7564 -18.46281,3.6764 -33.62102,5.4958 -55.09262,6.6126 -32.6486,1.6982 -55.9037,0.7551 -63.197,-2.5628 -1.851,-0.8421 -3.6295,-1.5578 -3.9522,-1.5905 -0.7577,-0.077 -19.5323,23.6767 -24.0242,30.3951 -7.0699,10.5745 -10.2531,24.661696 -7.3125,32.361696 2.7155,7.1105 9.583,12.2075 31.7769,23.5846 23.0673,11.8249 26.0021,14.2252 30.4478,24.9043 1.639,3.937 2.98,8.1671 2.98,9.4001 0,3.2034 -2.5739,10.165 -4.7094,12.7377 -3.8942,4.6915004 -10.2663,-1.0505 -12.1212,-10.9227 -0.5512,-2.933 -2.1029,-7.5456 -3.4484,-10.2503 -1.9795,-3.9791 -3.4535,-5.488 -7.7243,-7.9076 -2.9029,-1.6446 -10.3405,-6.1582 -16.528,-10.0304 -6.1875,-3.872 -18.9868,-11.5984 -28.443,-17.1698 -9.4561,-5.5713 -17.9792,-11.0792 -18.9403,-12.2396 -4.798,-5.794 -4.6062,-11.7942 0.5599,-17.5125 1.7748,-1.964496 4.0429,-5.419796 5.0401,-7.678396 1.7473,-3.9574 4.4795,-20.1604 3.5554,-21.0845 -0.2481,-0.2482 -1.8305,1.9937 -3.5164,4.9821 -5.2088,9.2329 -13.9125,16.9347 -25.6013,22.6541 -11.7569,5.752696 -19.4403,12.594596 -23.4115,20.847296 -2.5739,5.3489 -6.5034,23.8098 -8.1364,38.2253 -1.1019,9.7274 -0.2585,15.2609 3.2322,21.2065 2.9885,5.0903 5.7029,7.4584 12.2759,10.7100004 14.498,7.1717 13.7167,12.3782 -1.4583,9.71749997 z"
              id="path8085" />
          </g>
          </svg>
          @if(isset($sideBarLeft))
            @include('layouts.sidebar-left')
          @endif
        <div class="col pb-0" id="middle">
          @yield('middle') 
        </div>
      </main>
    
    </div> <!--Container-xxl-->
    @if($errors->has('auth.email') OR (Session::get('loginModal') == 'yes'))
      <script>
        $(function() {
            $('#loginModal').modal('show');
        });
      </script>
      @php Request:session()->forget('loginModal'); @endphp
    @endif
    <footer>
      <p>Les paniers de Laoul'ane ! &copy; {{ now()->year }} | <strong>@lang('Local producers in Morbihan, Brittany')</strong></p>
    </footer>
  </body>
</html>