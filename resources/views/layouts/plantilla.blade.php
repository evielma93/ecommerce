<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FishyGo</title>
    <link href="fishygo/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="fishygo/assets/img/favicon.png" />
    @stack('styles')
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous">
    </script>
    <script src="/js/axios.min.js"></script>
    <style>
        #FgProducts {
          background-image: url("fishygo/img/fondo2.jpg");
          background-position: center center;
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          background-color: #66999;
      }
  </style>
</head>
<body>

    @inject('cart', 'App\Classes\Cart')
    <div id="layoutDefault">
        <div id="layoutDefault_content">
            <main>
                <nav class="navbar navbar-marketing navbar-expand-lg bg-blue navbar-light shadow-lg">
                    <div class="container-fluid">
                        <img src="img/logo_new_fishy.png" alt="">
                        {{-- <a class="navbar-brand text-dark" href="index.html">FishyGo Online</a> --}}

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto mr-lg-5">
                                <li class="nav-item text-white">
                                    <a class="nav-link text-white" href="{{ route('shop') }}">TIENDA</a>
                                </li>
                                <li class="nav-item dropdown no-caret">
                                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdownDocs" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CATEGORÍAS
                                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                                        <div class="categories">CATEGORÍAS</div>
                                        <div class="dropdown-divider m-0"></div>
                                        @foreach($categories as $category)
                                        <a class="dropdown-item py-3" href="" target="_blank">
                                            <div class="icon-stack bg-primary-soft text-primary mr-4">
                                                {!! $category->icons !!}
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">{{ $category->name }}</div>
                                                {{ $category->description }}
                                            </div>
                                        </a>
                                        @endforeach
                                        <div class="dropdown-divider m-0" hidden></div>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('shop.cart') }}">
                                        <i class="fas fa-shopping-cart"></i> {{ $cart->hasProducts() }}
                                    </a>
                                </li>
                                @guest
                                <li class="nav-item text-white">
                                    <a class="nav-link text-white" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('register') }}">{{ __('REGISTRARSE') }}</a>
                                </li>
                                @endif
                                @else
                                <li class="nav-item dropdown text-white">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{ route('registerCli') }}">Mis Datos</a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>



                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                        <a class="btn-blue btn rounded-pill px-4 ml-lg-4" hidden href="#">
                            Pagar
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </nav>

            <section >

                <div class="container-fluid" id="FgProducts">
                    <div class="row">
                        <div class="container">
                            @if (isset($errors) && $errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (session()->has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    @foreach (session()->get('success') as $message)
                                    <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <div class="col-12">
                            @if(session('message'))
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="alert alert-{{ session('message')[0] }}">
                                        <h4 class="alert-heading">{{ __("Nueva acción") }}</h4>
                                        <p>{{ session('message')[1] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @yield('content')
                        </div>
                            {{-- <div class="col-3">
                                @include('layouts.sidebar')
                            </div> --}}
                        </div>
                    </div>


                </section>
                <hr class="my-0" />

                <section class="bg-blue py-10">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="text-uppercase-expanded text-white text-xs mb-4">SB UI Kit Pro</div>
                                <div class="mb-3 text-white">Build better websites</div>
                                <div class="icon-list-social mb-5 text-white">
                                    <a class="icon-list-social-link text-white" href="javascript:void(0);"><i class="fab fa-instagram"></i></a>
                                    <a class="icon-list-social-link text-white" href="javascript:void(0);"><i class="fab fa-facebook"></i></a>
                                    <a class="icon-list-social-link text-white" href="javascript:void(0);"><i class="fab fa-github"></i></a>
                                    <a class="icon-list-social-link text-white" href="javascript:void(0);"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                        <div class="text-uppercase-expanded text-white text-xs mb-4">Product</div>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2 text-white">
                                                <a href="javascript:void(0);" class="text-white">Landing</a></li>
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Pages</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Sections</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Documentation</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="text-white">Changelog</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                            <div class="text-uppercase-expanded text-white text-xs mb-4">Technical</div>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Documentation</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Changelog</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a href="javascript:void(0);" class="text-white">Theme Customizer</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="text-white">UI Kit</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="svg-border-rounded text-light">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
                        </div>
                    </section>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-10 pb-5 mt-auto bg-light footer-light">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-6 small">Copyright &copy; FishyGo 2020</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="javascript:void(0);">Privacy Policy</a>
                                &middot;
                                <a href="javascript:void(0);">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="fishygo/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="fishygo/js/scripts.js"></script>
        @yield('scripts')
        @stack('scriptsss')
    </body>
    </html>
