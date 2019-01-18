<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 18/01/2019
 * Time: 17:42
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
    $title=ucfirst($subtype);
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
@section('title') {{$title." · Bosnabooking"}} @endsection
@section('content')
    <!-- Start property Area -->
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw {{$ikon}}"></span> {{$title}}</h1>
                </div>
            </div>
            @if(Auth::user())
                <div class="row d-flex justify-content-center">
                    <button class="btn bgzuta hvzelena mb-3" onclick="window.location.href='{{asset('/new')}}'"><span class="fas fa-fw fa-plus"></span> Add accomodation</button>
                </div>
            @endif
            <div class="masonry">
                @foreach($acc as $a)
                    @if(!$zauzeto[$a->id])
                        <div class="baboitema" data-idina="{{asset("/accomodation")}}/{{rijesi($a->name)}}/{{$a->id}}{{isset($dp)&&isset($dk)?"/".$dp."/".$dk:""}}">
                            <div class="itemm single-property">
                                <div class="images">
                                    <img class="img-fluid mx-auto d-block"
                                         src="{{file_exists(public_path()."/img/slikebaza/".$a->folder."/main.jpg")?asset("img/slikebaza/".$a->folder."/main.jpg"):asset("img/no-image.png")}}" alt="">
                                    <span>{{$a->plejs->plejsp->name}}</span>
                                </div>
                                @php $vb="price".date("F"); @endphp
                                <div class="desc">
                                    <div class="top d-flex justify-content-between">
                                        <h4><a href="#">{{$a->name}}{!!$a->area?" · ".$a->area."&nbsp;m<sup>2</sup>":""!!}</a></h4>
                                        <h4>{{$iznos[$a->id]}}&nbsp;€</h4>
                                    </div>
                                    <table class="tbbl c">
                                        <tr>
                                            <td class="tajtl"><span class="fas fa-fw fa-group"></span></td>
                                            <td class="ttajtl">{{$a->capacity}}</td>
                                            <td class="tajtl"><span class="fas fa-fw fa-moon"></span></td>
                                            <td class="ttajtl">{{$a->minimumNumberOfNights}}</td>
                                        </tr>
                                        <tr>
                                            <td class="tajtl"><span class="fas fa-fw fa-wifi"></span></td>
                                            <td class="ttajtl">@if($a->internet)<span class="gr">Yes</span>@else<span class="rd">No</span>@endif</td>
                                            <td class="tajtl"><span class="fas fa-fw fa-percent"></span></td>
                                            <td class="ttajtl">{{$a->payingAhead?$a->payingAhead:0}}%</td>
                                        </tr>
                                        <tr>
                                            <td class="tajtl"><span class="fas fa-fw fa-snowflake"></span></td>
                                            <td class="ttajtl">@if($a->airCondition)<span class="gr">Yes</span>@else<span class="rd">No</span>@endif</td>
                                            <td class="tajtl"><span class="fas fa-fw fa-bed"></span></td>
                                            <td class="ttajtl">{{$a->bedRoom?$a->bedRoom:1}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    <!-- End property Area -->
@endsection
