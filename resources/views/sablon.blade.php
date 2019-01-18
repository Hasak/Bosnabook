<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 18/01/2019
 * Time: 17:45
 */
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="title" content="Bosnabooking · Book a House or an Apartment">
    <meta name="description" content="Agency that provides the most comfortable accomodations and trips to the most beautiful places in Bosnia and Herzegovina with tourist guides and drivers speaking several languages.">
    <meta name="keywords" content="Bosnia,Bosna,Tourism,Travel,Visit,Tours,Medical,Treatment">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Jusuf & Himzo">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#295097">

    <title>@yield("title","Bosnabooking")</title>
    <link rel="icon" href="{{asset("/img/core-img/fav.png")}}">
    <link href="{{asset("/css/style.css")}}" rel="stylesheet">
    <link href="{{asset("/css/bootstrap/bootstrap-datepicker3.standalone.css")}}" rel="stylesheet">
    <link href="{{asset("/css/responsive/responsive.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("/css/all.min.css")}}">
    <link href="{{asset("/css/gfont.css")}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Krub:200" rel="stylesheet">
    @yield('head')
</head>
<body>
{{--<div id="preloader">--}}
    {{--<div class="dorne-load"></div>--}}
{{--</div>--}}
<div class="dorne-search-form d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="search-close-btn" id="closeBtn">
                    <i class="pe-7s-close-circle" aria-hidden="true"></i>
                </div>
                <form action="#" method="get" id="src">
                    <input type="search" name="caviarSearch" id="search"
                           placeholder="Search Your Desire Destinations or Events">
                    <input type="submit" class="d-none" value="submit">
                </form>
            </div>
        </div>
    </div>
</div>
<header class="header_area" id="header">
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 h-100">
                <nav class="h-100 navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{asset("/")}}"><img id="logo"
                                                                       src="{{asset("/img/core-img/bosnia-travel-logo-horizontal.png")}}"
                                                                       alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#dorneNav"
                            aria-controls="dorneNav" aria-expanded="false" aria-label="Toggle navigation"><span
                                class="fa fa-bars"></span></button>

                    <div class="collapse navbar-collapse" id="dorneNav">
                        <ul class="navbar-nav mr-auto" id="dorneMenu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{asset('/')}}"><span
                                            class="fas fa-globe-europe fa-fw"></span> Home</a>
                            </li>
                            @foreach($types as $t)
                                @if($t->id==3)
                                    @continue;
                                @endif
                                @php $ima=false; @endphp
                                @if($t->id!=3)
                                    @foreach($subtypes as $s)
                                        @if($t->id==$s->typeid)
                                            @php $ima=true; @endphp
                                            @break
                                        @endif
                                    @endforeach
                                @endif
                                <li class="nav-item @if($ima)dropdown @endif">
                                    <a class="nav-link @if($ima)dropdown-toggle @endif"
                                       href="@if(!$ima)@if($t->id==3){{asset('/accomodation')}}@endif/{{$t->link}}@else#@endif"
                                       @if($ima)id="navbarDropdown" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"@endif><span
                                                class="{{$t->icon}} fa-fw"></span> {{$t->ime}}
                                        @if($ima)
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>@endif</a>
                                    @if($ima)
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            {{--@endif--}}
                                            @foreach($subtypes as $s)
                                                @if($t->id==$s->typeid)
                                                    <a class="dropdown-item hvplava"
                                                       href="{{asset('/accomodation/'.$t->link."/".$s->link)}}"><span
                                                                class="{{$s->icon}} fa-fw"></span> {{$s->ime}}</a>
                                                @endif
                                            @endforeach
                                            {{--@if($ima)--}}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @guest
                                        <span class="fa-fw fas fa-sign-in-alt"></span> <span
                                                class="d-lg-none">Enter</span>
                                    @else
                                        <span class="fa-fw fas fa-user"></span> <span
                                                class="d-lg-none">{{Auth::user()->username}}</span>
                                    @endguest
                                    <i class="fa fa-angle-down d-lg-none" aria-hidden="true"></i></a>
                                @guest
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item hvplava" href="{{ route('login') }}"><span
                                                    class="fa-fw fas fa-sign-in-alt"></span> {{ __('Login') }}</a>
                                        <a class="dropdown-item hvplava" href="{{ route('register') }}"><span
                                                    class="fa-fw fas fa-user-plus"></span> {{ __('Register') }}</a>
                                    </div>
                                @else
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <h6 class="dropdown-header c"><span
                                                    class="fa-fw fas fa-user"></span> {{Auth::user()->username}}</h6>
                                        @if(Auth::user()->username=="Destination")
                                            <a class="dropdown-item hvplava" href="{{asset('/new/car')}}"><span
                                                        class="fa-fw fas fa-plus"></span> Add car</a>
                                            <a class="dropdown-item hvplava" href="{{asset('/rentacar')}}"><span
                                                        class="fa-fw fas fa-car"></span> My cars</a>
                                            <a class="dropdown-item hvplava" href="{{asset('/rentings')}}"><span
                                                        class="fa-fw fas fa-calendar-check-o"></span> Rentings</a>
                                        @else
                                            <a class="dropdown-item hvplava" href="{{asset('/new')}}"><span
                                                        class="fa-fw fas fa-plus"></span> Add accomodation</a>
                                            <a class="dropdown-item hvplava" href="{{asset('/accomodation')}}"><span
                                                        class="fa-fw fas fa-home"></span> My accomodations</a>
                                            <a class="dropdown-item hvplava" href="{{asset('/reservations')}}"><span
                                                        class="fa-fw fas fa-calendar-check-o"></span> Reservations</a>
                                        @endif
                                        {{--<a class="dropdown-item" href="#">Another action</a>--}}
                                        <div class="dropdown-divider"></div>
                                        @if(Auth::user()->admin)
                                            <a class="dropdown-item hvplava" href="{{asset('/admin')}}"><span
                                                        class="fa-fw fas fa-cog fa-spin"></span> Admin Panel</a>
                                        @endif
                                        <a class="dropdown-item hvplava" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <span class="fa-fw fas fa-sign-out-alt"></span> {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                @endguest
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
@yield('content')
<footer class="dorne-footer-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h5><span class="fas fa-fw fa-address-card"></span> Contact:</h5>
                <div class="text-left d-inline-block">
                    <p class="bold">
                        <span class="fas fa-fw fa-building"></span> BosnaTravel d.o.o.<br>
                        <span class="fas fa-fw fa-map-pin"></span> Mustafe Pintola 23<br>
                        <span class="fas fa-fw fa-map-marked-alt"></span> 71210 Ilidža · Sarajevo<br>
                        <span class="fas fa-fw fa-globe-europe"></span> Bosna i Hercegovina<br>
                        <span class="fab fa-fw fa-whatsapp"></span><span class="fab fa-fw fa-viber"></span> <a
                                href="tel:+387603203030">+387 60 320 30 30</a><br>
                        <span class="fas fa-fw fa-envelope"></span> <a
                                href="mailto:bosnatravel@gmail.com">bosnatravel@gmail.com</a><br>
                        <span class="fas fa-fw fa-at"></span> <a
                                href="mailto:info@bosna-travel.ba">info@bosna-travel.ba</a>
                    </p>
                </div>
                <h5><span class="fas fa-fw fa-money-check-alt"></span> Bank account info:</h5>
                <div class="text-left d-inline-block">
                    <p class="bold">
                        <span class="fa-fw fas fa-university"></span> Bosna Bank International<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BAM 141-309-53200003-19<br>
                        <span class="fa-fw fas fa-money-check"></span> IBAN/Account number<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BA391413065310121016<br>
                        <span class="fa-fw fas fa-hashtag"></span> Swift or Bic code: BBIBBA22XXX
                    </p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                {{--<div>--}}
                <h5><span class="fas fa-fw fa-home"></span> Accomodation:</h5>
                <div class="text-left d-inline-block">
                    @foreach($types as $type)
                        @if($type->id==3)
                            @continue;
                        @endif
                        @php $ima=false; $mu=""; @endphp
                        @foreach($subtypes as $s)
                            @if($type->id==$s->typeid or $type->id==3)
                                @php $ima=true; $mu="accomodation/"; @endphp
                                @break
                            @endif
                        @endforeach
                        {{--<h1>{{"/".$mu.$type->link}}</h1>--}}
                        <h6><a class="siva hvplavac" href="{{asset("/".$mu.$type->link)}}"><span
                                        class="fa-fw {{$type->icon}}"></span> {{$type->ime}}</a></h6>
                        @foreach($subtypes as $subtype)
                            @if($subtype->typeid==$type->id and $type->id!=3)
                                <a class="linkss siva hvplavac"
                                   href="{{asset("/accomodation/".$type->link."/".$subtype->link)}}"><span
                                            class="fa-fw {{$subtype->icon}}"></span> {{$subtype->ime}}</a><br>
                            @endif
                        @endforeach
                    @endforeach
                </div>
                {{--</div>--}}
            </div>
            <div class="col-md-3">
                <h5><span class="fas fa-fw fa-user"></span> Account:</h5>
                <div class="text-left d-inline-block">
                    <div class="ind">
                        @if(Auth::user())
                            <span class="c bold ftrmsugiu siva"><span
                                        class="fa-fw fas fa-user"></span> {{Auth::user()->username}}</span><br>
                            <a class="siva hvplavac" href="{{asset('/new')}}"><span
                                        class="fa-fw fas fa-plus"></span> Add accomodation</a><br>
                            <a class="siva hvplavac" href="{{asset('/accomodation')}}"><span
                                        class="fa-fw fas fa-home"></span> My accomodations</a><br><br>
                            @if(Auth::user()->admin)
                                <a class="siva hvplavac" href="{{asset('/admin')}}"><span
                                            class="fa-fw fas fa-cog fa-spin"></span> Admin Panel</a><br>
                            @endif
                            <a class="siva hvplavac" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <span class="fa-fw fas fa-sign-out-alt"></span> {{ __('Logout') }}
                            </a>
                        @else
                            <a class="siva hvplavac" href="{{ route('login') }}"><span
                                        class="fa-fw fas fa-sign-in-alt"></span> {{ __('Login') }}</a><br>
                            <a class="siva hvplavac" href="{{ route('register') }}"><span
                                        class="fa-fw fas fa-user-plus"></span> {{ __('Register') }}</a><br>
                        @endif
                    </div>
                    <h5 class="text-center"><span class="fas fa-fw fa-share-alt mt-3"></span> Follow us:</h5>
                    <div class="ind fsss mb-3">
                        <a target="_blank"
                           href="https://instagram.com/bosnia_travel?utm_source=ig_profile_share&igshid=cjrxihs1oowo"
                           class="siva hvplavac"><span class="fa-fw fab fa-instagram"></span></a>
                        <a target="_blank" href="https://twitter.com/Bosnia_travel?s=08" class="siva hvplavac"><span
                                    class="fa-fw fab fa-twitter"></span></a>
                        <a target="_blank" href="https://www.facebook.com/Bosnia_travel-462407403950958/"
                           class="siva hvplavac"><span class="fa-fw fab fa-facebook"></span></a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCjegR29NXrhU5Fk4-WigySQ"
                           class="siva hvplavac"><span class="fa-fw fab fa-youtube"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <h5><span class="fas fa-fw fa-map-marker-alt"></span> Location:</h5>
                <div class="text-left d-inline-block">
                    <div id="map">
                        <iframe id="mapss" width="100%" height="270"
                                src="https://maps.google.com/maps?width=100%&amp;height=270&amp;hl=en&amp;q=Mustafe%20Pintola%2023+(BosniaTravel)&amp;ie=UTF8&amp;t=&amp;z=15&amp;iwloc=B&amp;output=embed"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<footer class="lastft bold">
    Copyright <span class="fa-fw fas fa-copyright"></span> {{date("Y")}} · BosniaTravel d.o.o.<br>
    Designed <span class="fa-fw fas fa-pencil-alt"></span> and programmed <span class="fa-fw fas fa-code"></span> by: <a
            href="#">Jusuf & Himzo</a>{{--By Ananaslı--}}
</footer>
<script src="{{asset("/js/jquery/jquery-2.2.4.min.js")}}"></script>
<script src="{{asset("/js/bootstrap/popper.min.js")}}"></script>
<script src="{{asset("/js/bootstrap/bootstrap.min.js")}}"></script>
<script src="{{asset("/js/others/plugins.js")}}"></script>
<script src="{{asset("/js/active.js")}}"></script>
<script src="{{asset("/js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("/js/animate.js")}}"></script>
<script src="{{asset("/js/custom.js")}}"></script>
<script src="{{asset("/js/ekko-lightbox.min.js")}}"></script>
<script src="{{asset("/js/nase.js")}}"></script>
</body>
</html>
