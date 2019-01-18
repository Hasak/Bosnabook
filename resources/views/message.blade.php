<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 07/02/2019
 * Time: 20:56
 */
?>
@extends("sablon")
@section('title') {{"Response · Bosnabooking"}} @endsection
@section('head')
    <link rel="stylesheet" href="{{asset("css/linearicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.skinFlat.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/owl.carousel.css")}}">
    <link rel="stylesheet" href="{{asset("css/owl.theme.default.min.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <link rel="stylesheet" href="{{asset("css/animate.css")}}">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
@endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1>{{$potvrda?$potvrda==1?"Potvrdjena":"Rezervacija je uspješno odbijena!":"Greška u kodu"}}</h1>
                </div>
            </div>
        </div>
    </section>
@endsection
