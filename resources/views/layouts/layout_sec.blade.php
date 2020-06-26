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
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
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
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto mr-lg-5">
                                <li class="nav-item text-white">
                                    <a class="nav-link text-white" href="{{ route('shop') }}">TIENDA</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route('shop.cart') }}">
                                        <i class="fas fa-shopping-cart"></i> {{ $cart->hasProducts() }}
                                    </a>
                                </li>
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
                            <div class="col-12">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </section>


            </main>
        </div><hr class="my-0" />
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
</body>
</html>
