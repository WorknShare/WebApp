@extends('layouts.app_public')

@section('content')

    @include('partials.frontoffice.navbar')

    <!--banner start-->
    <section class="ImageBackground Blurb Blurb--wrapper bg-primary bg-primary--gradient310 u-BorderRadius6 js-FullHeight js-Parallax" data-overlay="4">
        <div class="container u-vCenter">
            <div class="row text-center text-white">
                <div class="col-md-8 col-md-offset-2">
                    <h1 class="u-FontSize50 u-xs-FontSize40 u-Weight700 u-MargnTop0">Votre tremplin vers la productivité </h1>
                    <h4 class="u-MarginBottom50 text-white">Rejoignez nos espaces de coworking au coeur de Paris</h4>
                    <p>
                        <a class="btn btn-primary u-Rounded text-uppercase u-MarginRight20 u-xs-MarginBottom20" href="{{ route('register') }}">S'inscrire</a>
                        <a class="btn btn-white u-Rounded text-uppercase u-xs-MarginBottom20" href="{{ route('login') }}">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--banner end-->

    <!--features start-->
    <section class="u-PaddingTop150 u-PaddingBottom100 u-xs-PaddingTop70 u-xs-PaddingBottom0">
        <div class="container">
            <div class="row media">
                <div class="col-md-6 media-left media-middle u-sm-MarginBottom30">
                    <img class="img-responsive" src="{{ asset('landing/imgs/b11-600.jpg') }}" alt="...">
                </div>
                <div class="col-md-6 media-body media-middle">
                    <div class="u-PaddingLeft50 u-PaddingRight50 u-xs-Padding0">
                        <h1 class="u-MarginTop0 u-MarginBottom30">Qu'est-ce que c'est ?</h1>
                        <p class="u-LineHeight2">Work’n Share c’est votre espace de coworking au coeur de paris. Cet espace est dédié aux entrepreneurs, start ups, indépendants, salariés de tout horizon qui veulent travailler et recevoir leurs clients dans un cadre dynamique, convivial et professionnel.</p>

                    </div>
                </div>
            </div>
            <div class="row u-MarginTop150 u-xs-MarginTop30">
                <div class="col-md-4 col-sm-6 u-MarginBottom60">
                    <div class="u-PaddingRight40 u-md-Padding0 u-sm-PaddingRight20 u-xs-PaddingLeft20">
                        <i class="Icon Icon-mobile Icon--32px"></i>
                        <h3 class="u-MarginTop20">Fully Responsive</h3>
                        <div class="Split Split--height1 u-Block"></div>
                        <p class="u-MarginTop30 u-MarginBottom30">This one is a big one that has been haunting me since teenage years. When I was in highschool of University.</p>
                        <a class="btn-go" href="#" role="button">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 u-MarginBottom60">
                    <div class="u-PaddingLeft20 u-PaddingRight20 u-md-Padding0 u-sm-PaddingLeft20 u-xs-PaddingRight20">
                        <i class="Icon Icon-layers Icon--32px"></i>
                        <h3 class="u-MarginTop20">Highly Customizable</h3>
                        <div class="Split Split--height1 u-Block"></div>
                        <p class="u-MarginTop30 u-MarginBottom30">This one is a big one that has been haunting me since teenage years. When I was in highschool of University.</p>
                        <a class="btn-go" href="#" role="button">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 u-MarginBottom60">
                    <div class="u-PaddingLeft40 u-md-Padding0 u-sm-PaddingLeft10 u-sm-PaddingRight10 u-xs-PaddingLeft20 u-xs-PaddingRight20">
                        <i class="Icon Icon-support Icon--32px"></i>
                        <h3 class="u-MarginTop20">Amazing Support</h3>
                        <div class="Split Split--height1 u-Block"></div>
                        <p class="u-MarginTop30 u-MarginBottom30">This one is a big one that has been haunting me since teenage years. When I was in highschool of University.</p>
                        <a class="btn-go" href="#" role="button">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--features end-->

    <!--clients start-->
    <section class="u-PaddingTop50 Blurb Blurb--wrapper bg-primary bg-primary--gradient310 u-BorderRadius6">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <h1 class="u-MarginTop100 u-sm-MarginTop0 u-xs-MarginTop0">Nos clients parlent pour nous</h1>
                    <p class="u-lineheight3">Plus de 95% de nos clients sont satisfaits de la qualité de nos locaux et de nos services et en parlent !</p>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="u-PaddingLeft20 u-sm-Padding0 u-MarginTop100 u-sm-MarginTop0 u-xs-MarginTop0">
                        <div class="bg-info Blockquote u-BoxShadow40">
                            <div class="media u-OverflowVisible u-MarginTop0">
                                <div class="media-body media-middle">
                                    <p class="text-italic text-lg text-black u-MarginBottom30">Nous avons choisi d'utiliser Work'n Share pour la gestion de notre espace de coworking, parce qu'il permet à chaque membre de réserver en fonction de ses besoins. Work'n Share nous a permis de nous libérer des tâches administratives pour consacrer notre temps principalement à l'animation de l'espace de coworking.</p>
                                    <p class="text-black"><em>Bénédict D.</em></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="u-PaddingLeft20 u-sm-Padding0 u-MarginTop100 u-sm-MarginTop0 u-xs-MarginTop0">
                        <div class="bg-info Blockquote u-BoxShadow40">
                            <div class="media u-OverflowVisible u-MarginTop0">
                                <div class="media-body media-middle">
                                    <p class="text-italic text-lg text-black u-MarginBottom30">Choisir Work'n Share fut évident. Le service s'adapte parfaitement à nos besoins et est très pratique à utiliser. La gestion administrative et logistique est maintenant plus facile et nous donne plus de temps pour organiser des événements, promouvoir notre espace de travail et se concentrer sur la dimension humaine.</p>
                                    <p class="text-black" ><em>Bénédict D.</em></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--clients end-->

    <!--steps start-->
    <section class="u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom100">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 text-center">
                    <h1 class="u-MarginTop10 u-MarginBottom35">How it works</h1>
                </div>
                <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <p class="u-LineHeight2">Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima</p>
                    <p>
                        <a class="btn btn-go btn-go--info" href="#" role="button">Read The Story <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                    </p>
                </div>
            </div>
            <div class="row u-MarginTop100 u-xs-MarginTop50">
                <div class="col-md-12 text-center">
                    <div class="Steps">
                        <div class="Step">
                            <div class="Step__thumb u-BoxShadow100">
                                <span class="Step__thumb-number">01</span>
                                <i class="Icon Icon-user-group"></i>
                            </div>
                            <p class="u-MarginTop20 u-LineHeight2">Lid est laborum dolo rumes fugats.</p>
                        </div>
                        <div class="Step">
                            <div class="Step__thumb StepCurve StepCurve--down">
                                <img src="{{ asset('landing/imgs/step-downcurve.png') }}" alt="">
                            </div>
                        </div>
                        <div class="Step">
                            <div class="Step__thumb u-BoxShadow100">
                                <span class="Step__thumb-number">02</span>
                                <i class="Icon Icon-trophy"></i>
                            </div>
                            <p class="u-MarginTop20 u-LineHeight2">Lid est laborum dolo rumes fugats.</p>
                        </div>
                        <div class="Step">
                            <div class="Step__thumb StepCurve StepCurve--up">
                                <img src="{{ asset('landing/imgs/step-upcurve.png') }}" alt="">
                            </div>
                        </div>
                        <div class="Step">
                            <div class="Step__thumb u-BoxShadow100">
                                <span class="Step__thumb-number">03</span>
                                <i class="Icon Icon-support"></i>
                            </div>
                            <p class="u-MarginTop20 u-LineHeight2">Lid est laborum dolo rumes fugats.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--steps end-->

    <!--fun factor start-->
    <section class="bg-lighter u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom100">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 text-center">
                    <h1 class="u-MarginTop10 u-MarginBottom10">Alien Factors</h1>
                </div>
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <p class="u-LineHeight2">Lid est laborum dolo rumes fugats untras Etharums ser</p>
                </div>
            </div>
            <div class="row u-MarginTop70 u-xs-MarginTop40">
                <div class="col-md-4 col-sm-6 u-MarginBottom35">
                    <div class="u-BoxShadow40">
                        <div class="Blurb">
                            <div class="u-FlexCenter u-PaddingTop50 u-PaddingBottom50">
                                <div class="u-PaddingRight25">
                                    <i class="Blurb__hoverText Icon Icon-happy Icon--44px" aria-hidden="true"></i>
                                </div>
                                <div class="">
                                    <h2 class="js-CountTo u-Margin0" data-to="1256">1,256</h2>
                                    <small class="text-uppercase u-LetterSpacing1">Happy Client</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 u-MarginBottom35">
                    <div class="u-BoxShadow40">
                        <div class="Blurb">
                            <div class="u-FlexCenter u-PaddingTop50 u-PaddingBottom50">
                                <div class="u-PaddingRight25">
                                    <i class="Blurb__hoverText Icon Icon-trophy Icon--44px" aria-hidden="true"></i>
                                </div>
                                <div class="">
                                    <h2 class="js-CountTo u-Margin0" data-to="22030">22,030</h2>
                                    <small class="text-uppercase u-LetterSpacing1">Subscribes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3 u-MarginBottom35">
                    <div class="u-BoxShadow40">
                        <div class="Blurb">
                            <div class="u-FlexCenter u-PaddingTop50 u-PaddingBottom50">
                                <div class="u-PaddingRight25">
                                    <i class="Blurb__hoverText Icon Icon-download Icon--44px" aria-hidden="true"></i>
                                </div>
                                <div class="">
                                    <h2 class="js-CountTo u-Margin0" data-to="105000">105,000</h2>
                                    <small class="text-uppercase u-LetterSpacing1">Download</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--fun factor end-->

    <!--image post start-->
    <section class="u-BoxShadow40 u-xs-PaddingBottom50">
        <div class="ImageBlock ImageBlock--switch">
            <div class="ImageBlock__image col-md-6 col-sm-4">
                <div class="ImageBackground ImageBackground--overlay u-BoxShadow100" data-overlay="0">
                    <div class="ImageBackground__holder">
                        <img src="{{ asset('landing/imgs/b10-1200.jpg') }}" alt="...">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-7">
                        <h1 class="u-MarginTop20 u-MarginBottom15 u-xs-MarginTop0">Why people like Alien</h1>
                        <p>Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats.</p>
                        <h5 class="u-Weight700 u-MarginBottom10">Reason One</h5>
                        <p>Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers.</p>
                        <h5 class="u-Weight700 u-MarginBottom10">Reason two</h5>
                        <p>Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima sadips.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--image post end-->

    <!--plan start-->
    <section class="u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom70">
        <div class="container">
            <div class="row media">
                <div class="col-md-4 media-left media-middle">
                    <div class="u-PaddingRight20 u-sm-PaddingRight0 u-sm-MarginBottom40">
                        <h1 class="u-MarginTop0">Pricing Plan</h1>
                        <p class="u-LineHeight2">Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers sadips amets. Lid est laborum dolo rumes fugats untras.</p>
                    </div>
                </div>
                <div class="col-md-8 media-body media-middle">
                    <div class="row text-center u-xs-MarginTop50">
                        <div class="col-sm-6 u-xs-MarginBottom40">
                            <div class="u-BoxShadow100">
                                <div class="Blurb Blurb--wrapper u-BorderRadius6">
                                    <h3 class="Blurb__hoverText u-MarginTop0">Free</h3>
                                    <div class="Blurb__hoverText u-FontSize50 u-Weight700">
                                        <small class="u-InlineBlock u-VerticalMiddle">$</small>0
                                    </div>
                                    <small class="Blurb__hoverText text-muted text-uppercase">Per month</small>
                                    <div class="u-MarginTop35 u-MarginBottom35 u-LineHeight3">
                                        - 24/7 Tech Support
                                        <br>
                                        - Advanced Options
                                        <br>
                                        - 1GB Storage
                                        <br>
                                        - 1GB Bandwidth
                                    </div>
                                    <a class="Blurb__hoverBtn btn btn-default u-Rounded u-Weight300" href="#">Purchase This</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="u-BoxShadow100">
                                <div class="Blurb Blurb--wrapper u-BorderRadius6">
                                    <h3 class="Blurb__hoverText u-MarginTop0">Premium</h3>
                                    <div class="Blurb__hoverText u-FontSize50 u-Weight700">
                                        <small class="u-InlineBlock u-VerticalMiddle">$</small>29
                                    </div>
                                    <small class="Blurb__hoverText text-muted text-uppercase">Per month</small>
                                    <div class="u-MarginTop35 u-MarginBottom35 u-LineHeight3">
                                        - 24/7 Tech Support
                                        <br>
                                        - Advanced Options
                                        <br>
                                        - 1GB Storage
                                        <br>
                                        - 1GB Bandwidth
                                    </div>
                                    <a class="Blurb__hoverBtn btn btn-default u-Rounded u-Weight300" href="#">Purchase This</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--plan end-->

    <!--pricing  start-->
    <section class="u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom70 u-BoxShadow40">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 text-center">
                    <h1 class="u-MarginTop10 u-MarginBottom10">Start building your site right now with Alien</h1>
                </div>
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <p class="u-LineHeight2 u-MarginBottom40">Lid est laborum dolo rumes fugats untras Etharums ser.</p>
                    <p>
                        <a class="btn btn-primary u-Rounded text-uppercase" href="#" role="button">Purchase Alien Here</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--pricing  end-->

    <!--footer start-->
    <footer class="bg-darker u-PaddingTop70 u-xs-PaddingTop50">
        <div class="container text-sm">
            <div class="row">
                <div class="col-md-3 u-xs-MarginBottom30">
                    <div class="logo u-MarginBottom25">
                        <img src="{{ asset('landing/imgs/logo-light.png') }}" alt="">
                    </div>
                    <p>Alien is  fully responsible, performance oriented and SEO optimized, retina ready HTML template.</p>
                    <h5 class="u-Weight700">Alien LLC</h5>
                    <p>Street nr 100, 4536534, Chicago, US</p>

                    <p>T (212) 555 55 00 <br>
                    Email: sales@yourwebsite.com
                    </p>
                </div>
                <div class="col-md-3 u-xs-MarginBottom30">
                    <h5 class="text-uppercase u-Weight800 u-LetterSpacing2 u-MarginTop0">Follow Us</h5>
                    <ul class="light-gray-link border-bottom-link list-unstyled u-LineHeight2 u-PaddingRight40 u-xs-PaddingRight0">
                        <li> <a href="#"><i class="fa fa-angle-right u-MarginRight10" aria-hidden="true"></i>About Us</a></li>
                        <li> <a href="#"><i class="fa fa-angle-right u-MarginRight10" aria-hidden="true"></i>Career</a></li>
                        <li> <a href="#"><i class="fa fa-angle-right u-MarginRight10" aria-hidden="true"></i>Terms &amp; Condition</a></li>
                        <li> <a href="#"><i class="fa fa-angle-right u-MarginRight10" aria-hidden="true"></i>Privacy Policy</a></li>
                        <li> <a href="#"><i class="fa fa-angle-right u-MarginRight10" aria-hidden="true"></i>Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3 u-xs-MarginBottom30">
                    <h5 class="text-uppercase u-Weight800 u-LetterSpacing2 u-MarginTop0">Recent Post</h5>
                    <ul class="light-gray-link list-unstyled u-MarginBottom0">
                        <li class="u-MarginBottom15">
                            <a class="" href="#">
                                The ultimate guide to freelancing as a creative...
                            </a>
                            <p class="">24 February 2017</p>
                        </li>
                        <li class="u-MarginBottom15">
                            <a class="" href="#">
                                Searching for the best UX: search forms and boxes in web design
                            </a>
                            <p>19 January 2017</p>
                        </li>
                        <li class="u-MarginBottom15">
                            <a class="" href="#">
                                Top 10 free tools for frontend web development
                            </a>
                            <p>2 January 2017</p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="text-uppercase u-Weight800 u-LetterSpacing2 u-MarginTop0">Subscribe</h5>

                    <form action="">
                        <input class="form-control" placeholder="Enter Email" type="email">
                    </form>

                    <h5 class="text-uppercase u-Weight800 u-LetterSpacing2 u-MarginTop50">We are Social</h5>
                    <div class="social-links sl-default gray-border-links border-link circle-link colored-hover">
                        <a href="#" class="facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#" class="twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#" class="g-plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                        <a href="#" class="youtube">
                            <i class="fa fa-youtube"></i>
                        </a>
                        <a href="#" class="dribbble">
                            <i class="fa fa-dribbble"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class="text-center u-MarginTop30">
            <div class="footer-separator"></div>
            <p class="u-MarginBottom0 u-PaddingTop30 u-PaddingBottom30">Copyright 2017 @ Alien Template.</p>
        </div>
    </footer>
    <!--footer end-->
@endsection