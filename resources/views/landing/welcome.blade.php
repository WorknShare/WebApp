@extends('layouts.app_public')

@section('css')
<link rel="stylesheet" href="{{ asset('css/comparative.css') }}">
@endsection

@section('navigation')
@include('partials.frontoffice.navbar')
@endsection

@section('content-wrapper')

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


    <section class="u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom70">
        <div class="container">
            <div class="row media">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-md-12 media-left media-middle">
                            <div class="u-PaddingRight20 u-sm-PaddingRight0 u-sm-MarginBottom40">
                                <h1 class="u-MarginTop0">Forfaits</h1>
                            </div>
                        </div>
                    </div>
                </div>
                @component('components.plan_comparative', [
                  'plans' => $plans,
                  'planAdvantages'=> $planAdvantages,
                  'reserveCount' => $reserveCount,
                  'orderMealCount' => $orderMealCount])
                @endcomponent
            </div>
        </div>
    </section>

    <section class="u-PaddingTop150 u-PaddingBottom150 u-xs-PaddingTop70 u-xs-PaddingBottom70 u-BoxShadow40">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 text-center">
                    <h1 class="u-MarginTop10 u-MarginBottom10">Vivez l'expérience Work'n Share dès maintenant !</h1>
                </div>
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <p class="u-LineHeight2 u-MarginBottom40">Inscrivez-vous et profitez directement de nos services.</p>
                    <p>
                        <a class="btn btn-primary u-Rounded text-uppercase" href="{{ route('register') }}" role="button">Inscrivez-vous !</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    @component('components.footer_front')
    @endcomponent
@endsection