<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 12/02/2019
 * Time: 21:42
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
@section('title') {{$title." · Bosnabooking"}} @endsection
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
        return $str;
    }
@endphp
@section('content')
    <!-- Start property Area -->
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-car"></span> {{$title}}</h1>
                </div>
            </div>
            @if(Auth::id() and (Auth::user()->admin or Auth::user()->username=="Destination"))
                <div class="row d-flex justify-content-center">
                    <button class="btn bgzuta hvzelena mb-3" onclick="window.location.href='{{asset('/new/car')}}'"><span class="fas fa-fw fa-plus"></span> Add car</button>
                </div>
            @endif
            <div class="row">
                @php $i=1; @endphp
                @foreach($rent as $a)
                        <div class="baboitemarentt col-md-3" data-idina="{{asset("/car")}}/{{rijesi($a->name)}}/{{$a->id}}">
                            <div class="itemmm itemm single-property ptr" data-ime="{{$a->name}}" data-cijena="{{$a->cijena}}" data-id="{{$a->id}}">
                                <div class="images">
                                    <img class="img-fluid mx-auto d-block"
                                         src="{{file_exists(public_path()."/img/auta/auto".$a->id.".jpg")?asset("/img/auta/auto".$a->id.".jpg"):asset("img/noimagecar.jpg")}}" alt="">
                                    <span>{{$a->tajp->ime}}</span>
                                </div>

                                <div class="desc">
                                    <div class="top d-flex justify-content-between">
                                        <h4 id="sajz"><a href="#">{{$a->name}}</a></h4>
                                        <h4 id="sajz">{{$a->cijena}}&nbsp;€</h4>
                                    </div>
                                    <table class="tbbl c">
                                        <tr>
                                            <td class="tajtl"><span class="fa-fw fas fa-gas-pump"></span> </td>
                                            <td class="ttajtl">{{$a->gorivoo->ime}}</td>
                                            <td class="tajtl"><span class="fa-fw fas fa-cogs"></span> </td>
                                            <td class="ttajtl">{{$a->automatik?"Automatic":"Manual"}}</td>
                                        </tr>
                                        <tr>
                                            <td class="tajtl"><span class="fa-fw fas fa-snowflake"></span> </td>
                                            <td class="ttajtl">@if($a->klima)<span class="gr">Yes</span>@else<span class="rd">No</span>@endif</td>
                                            <td class="tajtl"><span class="fa-fw fas fa-hashtag"></span> </td>
                                            <td class="ttajtl">{{$a->brsjedista}}</td>
                                        </tr>
                                        <tr>
                                            <td class="tajtl"><span class="fa-fw fas fa-suitcase-rolling"></span> </td>
                                            <td class="ttajtl">{{$a->kofkap}}</td>
                                            <td class="tajtl"><span class="fa-fw fas fa-address-card"></span> </td>
                                            <td class="ttajtl">{{$a->godine}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @if($i++%4==0)
                        </div><div class="row">
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- End property Area -->
@endsection

