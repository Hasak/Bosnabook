<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 22/02/2019
 * Time: 10:43
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
        $str=str_ireplace("Š","S",$str);
        $str=str_ireplace("Đ","Dj",$str);
        $str=str_ireplace("Č","C",$str);
        $str=str_ireplace("Ć","C",$str);
        $str=str_ireplace("Ž","Z",$str);
        $str=strtolower($str);
        $str=preg_replace('/\s+/', '', strtolower($str));
        return $str?$str:"dest";
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
                    <h1><span class="fa-fw fas fa-map-marked-alt"></span> Destinations</h1>
                </div>
            </div>
            <div class="masonry">
                @foreach($dest as $a)
                        <div class="baboitema" data-idina="{{asset("/destinations")}}/{{rijesi($a->ime)}}/{{$a->id}}">
                            <div class="itemm single-property">
                                <div class="images">
                                    <img class="img-fluid mx-auto d-block"
                                         src="{{file_exists(public_path()."/img/dest/".$a->folder."/main.jpg")?asset("img/dest/".$a->folder."/main.jpg"):asset("img/no-image.png")}}" alt="Photo of the destination">
                                    <span>{{$a->plejs->plejsp->name}}</span>
                                </div>

                                <div class="desc">
                                    <div class="top d-flex justify-content-between">
                                        <h4><a href="#">{{$a->ime}}</a></h4>
                                    </div>
                                    <div class="tbbl">
                                        {{$a->stext}}
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
