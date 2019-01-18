<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 20/02/2019
 * Time: 13:45
 */
?>
@extends('sablon')
@section('head')
    <link rel="stylesheet" href="{{asset("css/linearicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.skinFlat.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ekko-lightbox.css")}}">
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
@section('title') {{"Medical Treatment · Bosnabooking"}} @endsection
@section('content')
    <!-- Start property Area -->
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 header-text" style="margin-top: 50px">
                    <h1><span class="ehajsad fa-fw fas fa-heartbeat"></span> {{$subtype}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="bijelo bold jst">
                        The spa and rehabilitation center Ilidža Terme is situated 7 km from the center of Sarajevo, 2 km from
                        the International Airport Sarajevo, around 20 km from the Olympic Mountains Igman and Bjelašnica and 3
                        km from the most popular holiday resorts in Sarajevo Well of Bosnia (Vrelo Bosne).
                    </p>
                    <p class="bijelo bold jst">
                        Health Rehabilitation Institution Spa " Terme Ilidža" is great for relaxation and rehabilitation of
                        patients in the field of physical medicine and rehabilitation, Internal Medicine, gynecology, urology
                        and laboratory analysis services.
                    </p>
                    <p class="bijelo bold jst">
                        First analysis of healing thermal mineral water that we use in our spa (chemical composition and
                        balneological opinion) was made by prof. Dr. Ernest Ludwig of Vienna, Austria in the year 1894.
                        According to its physical-chemical properties of mineral water, sulphurous hyperthermal (T - 57.5 ° C)
                        with plenty of minerals from many sources. There is also mineral mud and peat. The healing mineral water
                        have been proven multiple times.
                    </p>
                    <p class="bijelo bold jst">
                        Content of Spas at Terme Ilidža: Center for Physical and Medical Rehabilitation with hydrotherapy and
                        physical therapy (electrotherapy, ultrasound therapy, thermotherapy, limfoterapija-cellulite removal,
                        treatment of the locomotor apparatus, circulation, UV therapy, vacuum massage, magnetic therapy, laser
                        IR) , wellness center, two indoor pools, fitness center, sauna, massage parlors, thermal baths, standing
                        and lying solarium, free parking for guests and visitors with physical and video surveillance.
                    </p>
                    <ul class="ulovi bijelo bold ind">
                        <li>Metabolic disease (diabetes, gout)</li>
                        <li>States after injuries of locomotor apparatus</li>
                        <li>Before and postoperative rehabilitation after surgery of the locomotor apparatus (bones, muscles, ligaments, joints, nerves)</li>
                        <li>Condition after stroke</li>
                        <li>Rehabilitation of amputees</li>
                        <li>Programmed active holiday</li>
                        <li>Managerial syndrome</li>
                        <li>Peripheral circulation disorders / weight loss program</li>
                    </ul>
                    <h4 class="mt-3 zuta">Indications for treatment:</h4>
                    <ul class="ulovi bijelo bold ind">
                        <li>All kinds of rheumatic, miopathic and neuropathic diseases</li>
                        <li>Spondylosis spinal column and its accompanying symptoms</li>
                        <li>Discus hernia</li>
                        <li>Radiculopatia</li>
                        <li>Painful syndromes of the spine and extremities</li>
                        <li>Osteoporosis</li>
                        <li>Skin diseases - psoriasis</li>
                        <li>Chronic diseases of urogenital organs</li>
                        <li>Primary and secondary infertility</li>
                        <li>Reducing blood pressure</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/6LyFGYYc-8A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div class="row c vc">
                        @php $i=1; @endphp
                        @foreach(glob("img/medics/*{.jpg,.JPG}",GLOB_BRACE) as $slik)
                            {{--@if(substr($slik,strlen($slik)-8,4)!=="main")--}}
                            <div class="col-3 mb-3 damoguuzetzadnjeg">
                                <a class="box-1" href="{{asset($slik)}}"
                                   data-toggle="lightbox" data-gallery="example-gallery3">
                                    <div class="nasaklasa">
                                        <img class="img-fluid imgg damoguuzetzadnjeg2" src="{{asset($slik)}}">
                                    </div>
                                </a>
                            </div>
                            {!!$i++%4==0?"</div><div class='row c vc'>":""!!}
                            {{--@endif--}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End property Area -->
@endsection
