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
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>@yield("title","Bosniabook · Book a House or an Apartment")</title>
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
<!-- Preloader -->
<div id="preloader">
    <div class="dorne-load"></div>
</div>

<!-- ***** Search Form Area ***** -->
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

<!-- ***** Header Area Start ***** -->

<!-- ***** Header Area End ***** -->

<!-- ***** Welcome Area Start ***** -->
@yield('content')
<!-- ***** Clients Area End ***** -->

<!-- ****** Footer Area Start ****** -->

<!-- ****** Footer Area End ****** -->

<!-- jQuery-2.2.4 js -->
<script src="{{asset("/js/jquery/jquery-2.2.4.min.js")}}"></script>
<!-- Popper js -->
<script src="{{asset("/js/bootstrap/popper.min.js")}}"></script>
<!-- Bootstrap-4 js -->
<script src="{{asset("/js/bootstrap/bootstrap.min.js")}}"></script>
<!-- All Plugins js -->
<script src="{{asset("/js/others/plugins.js")}}"></script>
<!-- Active JS -->
<script src="{{asset("/js/active.js")}}"></script>
<script src="{{asset("/js/bootstrap-datepicker.min.js")}}"></script>
<script src="{{asset("/js/animate.js")}}"></script>
<script src="{{asset("/js/custom.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="{{asset("/js/nase.js")}}"></script>
</body>

</html>
