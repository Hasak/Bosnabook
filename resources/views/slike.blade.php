<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 11/02/2019
 * Time: 19:20
 */
?>

@extends("sablon")
@section('head')
    <link rel="stylesheet" href="{{asset("css/linearicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.skinFlat.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/owl.carousel.css")}}">
    <link rel="stylesheet" href="{{asset("css/owl.theme.default.min.css")}}">
    <link rel="stylesheet" href="{{asset("css/ekko-lightbox.css")}}">
    <link rel="stylesheet" href="{{asset("css/animate.css")}}">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("/css/chc.css")}}">
@endsection
@section("title") Photos · {{$ime}} · Bosnabooking @endsection
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
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-photo"></span> Dodaj slike</h1>
                    <h3 class="bijelo">{{$ime}}</h3>
                </div>
            </div>
            <form id="formetina" action="{{asset("/slike")}}" method="post" class="formazadodat" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <div class="col">
                        {{--<div class="alert alert-info alert-dismissible fade show" role="alert">--}}
                            {{--<strong class="bold">Accomodation added! ({{$id}})</strong> Now add photos and mark <span class="ul">the main</span> photo--}}
                            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                {{--<span aria-hidden="true">&times;</span>--}}
                            {{--</button>--}}
                        {{--</div>--}}
                        {{--<div class="alert alert-success alert-dismissible fade show" role="alert">--}}
                            {{--<strong class="bold">Photos added! ({{$id}})</strong> Check them and mark <span class="ul">the main</span> one<br><br>{{$err}}--}}
                            {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                                {{--<span aria-hidden="true">&times;</span>--}}
                            {{--</button>--}}
                        {{--</div>--}}
                        <input type="hidden" name="accid" value="{{$id}}">
                        <input type="file" name="slike[]" id="file-4" class="inputfile inputfile-3" data-multiple-caption="{count} photos selected" multiple />
                        <label for="file-4"><i class="fa-fw fas fa-file-photo-o"></i> <span>Choose photos</span> <small class="text-secondary">(Max 50 photos, max 100 MB each upload, 8 MB per photo)</small></label>
                        <button type="submit" id="batntntn" class="btn hvzelena bgzuta float-right"><span class="fa-fw fas fa-upload"></span> Upload</button>
                    </div>
                </div>
                <div class="row c vc">
                    @php $i=1; @endphp
                    @foreach(glob("img/slikebaza/".$acc->folder."/*.jpg") as $slik)
                        {{--@if(substr($slik,strlen($slik)-8,4)!=="main")--}}
                        <div class="col-3 mb-3 damoguuzetzadnjeg" id="slikic{{$i}}">
                            <a class="box-1" href="{{asset($slik)}}"
                               data-toggle="lightbox" data-gallery="example-gallery">
                                <div class="nasaklasa">
                                    <img class="img-fluid imgg damoguuzetzadnjeg2" src="{{asset($slik)}}">
                                </div>
                            </a>
                            <div class="mt-1">
                                <button type="submit" class="btn btnslike btn-sm btn-danger mb-1 mt-1" data-josdate="{{$i}}" data-koji="brisi" data-path="{{$slik}}"><span class="fa-fw fas fa-trash"></span> Delete</button>
                                @if(substr($slik,strlen($slik)-8,8)!="main.jpg")
                                    <button type="submit" class="btn btnslike btn-sm bijelo bgplava" data-josdate="{{$i}}" data-koji="main" data-path="{{$slik}}"><span class="fa-fw fas fa-check"></span> Main</button>
                                @endif
                            </div>
                        </div>
                        {!!$i++%4==0?"</div><div class='row c vc'>":""!!}
                        {{--@endif--}}
                    @endforeach
                </div>
                <div class="row mt-4">
                    <div class="col c vc">
                        <button class="btn bgzuta hvzelena" onclick="window.location.href='{{asset("/accomodation/".rijesi($ime)."/".$id)}}';return false;"><span class="fa-fw fas fa-flag-checkered"></span> Finish</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection