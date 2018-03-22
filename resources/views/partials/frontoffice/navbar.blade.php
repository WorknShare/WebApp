<header>
  <nav class="navbar navbar-default navbar-fixed navbar-transparent dark white--outline-- bootsnav">

      <div class="container">

          <!-- Start Header Navigation -->
          <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                  <i class="fa fa-bars"></i>
              </button>
              <a class="navbar-brand" href="{{ route('welcome') }}">
                  <img src="{{ asset('img/banner64_2.png') }}" class="logo logo-display" alt="">
                  <img src="{{ asset('img/banner64.png') }}" class="logo logo-scrolled" alt="">
              </a>
          </div>
          <!-- End Header Navigation -->

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-menu">
              <ul class="nav navbar-nav navbar-right" data-in="" data-out="">
                  @if(!Auth::check())
                  <li>
                      <a href="{{ route('login') }}">Se connecter</a>
                  </li>
                  <li>
                      <a href="{{ route('register') }}">S'inscrire</a>
                  </li>
                  @else
                  <li> <a href="">{{ Auth::user()->surname . ' ' . Auth::user()->name }} </a></li>
                  <li> 
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">Se déconnecter</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                  </li>
                  @endif
              </ul>
          </div>
      </div>
  </nav>
  <!-- End Navigation -->
  <div class="clearfix"></div>
</header>