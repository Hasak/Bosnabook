<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 10/02/2019
 * Time: 23:09
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
    <link rel="stylesheet" href="{{asset("css/ekko-lightbox.com")}}">
    <link rel="stylesheet" href="{{asset("css/animate.css")}}">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("/css/chc.css")}}">
@endsection
@section("title") {{isset($acc)?"Edit · ".$acc->name:"Add Accomodation"}} · Bosnabooking @endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-plus"></span> Dodaj nekretninu</h1>
                </div>
            </div>
            <form action="{{asset("/insert")}}" method="post" class="formazadodat">
                <div class="row">
                    @csrf
                    <input type="hidden" name="jeledit" value="{{isset($acc)?$acc->id:0}}">
                    <div class="col-md-8 trrrr">
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="name"><span class="fa-fw fas fa-file-signature"></span> Name:</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg" @if(isset($acc)) value="{{$acc->name}}" @endif required>
                            </div>
                        </div>
                        <div class="form-row mb-5">
                            <div class="col-6">
                                <label for="type"><span class="fa-fw fas fa-certificate"></span> Type:</label>
                                <select name="subtype" id="type" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose type...</option>
                                    @foreach($types as $type)
                                        @foreach($subtypes as $s)
                                            @if($s->typeid==$type->id)
                                                <option value="0" class="font-weight-bold"
                                                        disabled>{{$type->ime}}</option>
                                                @break
                                            @endif
                                        @endforeach
                                        @foreach($subtypes as $s)
                                            @if($s->typeid==$type->id)
                                                <option value="{{$s->id}}" @if(isset($acc)) {{$acc->subtype==$s->id?"selected":""}} @endif >
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$s->ime}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="place"><span class="fa-fw fas fa-map-marker-alt"></span> Place:</label>
                                <select name="place" id="place" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose place...</option>
                                    @foreach($mj as $type)
                                        @foreach($subm as $s)
                                            @if($s->placeid==$type->id)
                                                <option value="0" class="font-weight-bold"
                                                        disabled>{{$type->name}}</option>
                                                @break
                                            @endif
                                        @endforeach

                                        @foreach($subm as $s)
                                            @if($s->placeid==$type->id)
                                                <option value="{{$s->id}}" @if(isset($acc)) {{$acc->place==$s->id?"selected":""}} @endif >
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$s->name}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @php $ii=0; @endphp
                        <div class="form-row mb-3">
                            @foreach($cols2 as $c)
                                @if($ii++==23)
                                    @break
                                @endif
                                @php
                                    $fic=$c;
                                    for ($i=1;$i<strlen($fic);$i++){
                                        if($fic[$i]=="/"){
                                            $fic[$i+1]=strtoupper($fic[$i+1]);
                                        }
                                        else if($fic[$i-1]!="/" and $fic[$i]==strtoupper($fic[$i])){
                                            for($j=strlen($fic)-1;$j>$i;$j--){
                                                $fic[$j+1]=$fic[$j];
                                            }
                                            //$fic[$j+1]=strtolower($fic[$j+1]);
                                            $fic[$i+1]=strtolower($fic[$i]);
                                            $fic[$i]=" ";
                                            //echo $fic."<br>";
                                            //$fic[$j]=' ';
                                        }
                                    }
                                    $fic[0]=strtoupper($fic[0]);
                                    if($fic[strlen($fic)-1]=="c" and $fic[strlen($fic)-2]=="W")
                                        $fic[strlen($fic)-1]="C";
                                @endphp
                                <div class="col-md-4">
                                    <label for="{{$c}}"><span class="fa-fw {{$ikone[$ii-1]->ikona}}"></span> {{$fic}}
                                    </label>
                                    <input class="form-control form-control-sm" type="number" min="0"
                                           name="{{$c}}" id="{{$c}}" @if(isset($acc)) value="{{$acc->$c}}" @endif @if($ii==2 or $ii>3 and $ii<16) required @endif>
                                </div>
                                @if($ii%3==0)
                        </div>
                        <div class="form-row mb-3">
                            @endif
                            @endforeach
                            {{--<div class="col-md-4">--}}
                                {{--<label for="files"><span class="fa-fw fas fa-image"></span> Photos:</label>--}}
                                {{--<input class="form-control form-control-sm" type="file" multiple required>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <div class="col-md-4 mt-4 checkboxes-and-radios">
                        @foreach($cols as $col)
                            @php
                                $fic=$col;
                                for ($i=1;$i<strlen($fic);$i++){
                                    if($fic[$i]=="/"){
                                        $fic[$i+1]=strtoupper($fic[$i+1]);
                                    }
                                    else if($fic[$i-1]!="/" and $fic[$i]==strtoupper($fic[$i])){
                                        for($j=strlen($fic)-1;$j>$i;$j--){
                                            $fic[$j+1]=$fic[$j];
                                        }
                                        //$fic[$j+1]=strtolower($fic[$j+1]);
                                        $fic[$i+1]=strtolower($fic[$i]);
                                        $fic[$i]=" ";
                                        //echo $fic."<br>";
                                        //$fic[$j]=' ';
                                    }
                                }
                                $fic[0]=strtoupper($fic[0]);
                                if($fic[strlen($fic)-1]=="c" and $fic[strlen($fic)-2]=="W")
                                    $fic[strlen($fic)-1]="C";
                            @endphp

                            <div class="form-check">
                                <input type="checkbox" name="{{$col}}" id="{{$col}}" value="1" @if(isset($acc)) {{$acc->$col?"checked":""}} @endif >
                                <label for="{{$col}}"><span class="fa-fw {{$ikone[$ii++-1]->ikona}}"></span> {{$fic}}
                                </label>
                            </div>
                        @endforeach
                            <div class="form-row mt-5 text-right">
                                <button type="submit" class="btn btn-block btn-lg hvzelena bgzuta">Next <span class="fa-fw fas fa-chevron-right"></span></button>
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection