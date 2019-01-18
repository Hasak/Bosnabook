<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 22/02/2019
 * Time: 10:59
 */
?>
@extends('sablon')
@section('head')
    <link rel="stylesheet" href="{{asset("css/linearicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.skinFlat.css")}}"/>
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
@endsection
@php
    function rijesi($str){
        $str=str_ireplace("š","s",$str);
        $str=str_ireplace("đ","dj",$str);
        $str=str_ireplace("č","c",$str);
        $str=str_ireplace("ć","c",$str);
        $str=str_ireplace("ž","z",$str);
        $str=strtolower($str);
        $str=preg_replace('/\s+/', '', strtolower($str));
        return $str;
    }
@endphp
@section('title') Destinations · Bosnabooking @endsection
@section('content')
    <!-- Start property Area -->
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center mb-5">
                <div class="col-md-8 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-map-marked-alt"></span> {{$dest->ime}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <a class="box-1" href="{{file_exists(public_path()."/img/dest/".$dest->folder."/main.jpg")?asset("img/dest/".$dest->folder."/main.jpg"):asset("img/no-image.png")}}"
                       data-toggle="lightbox" data-gallery="example-gallery34">
                        <img id="maglavnaba" src="{{file_exists(public_path()."/img/dest/".$dest->folder."/main.jpg")?asset("img/dest/".$dest->folder."/main.jpg"):asset("img/no-image.png")}}" alt="Main Photo"
                             class="img-thumbnail zb mb-2 bn">
                    </a>
                    <h4 class="bijelo mt-3 mb-3 c"><span class="fa-fw fas fa-map-marker-alt"></span> {{$dest->plejs->name}}
                        · {{$dest->plejs->plejsp->name}}</h4>
                </div>
                <div class="col-md-8">
                    <p class="bijelo jst bold">
                        {{$dest->text}}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

