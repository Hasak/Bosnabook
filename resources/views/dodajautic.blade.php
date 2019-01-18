<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 05/03/2019
 * Time: 19:23
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
@section("title") {{isset($acc)?"Edit · ".$acc->name:"Add Car"}} · Bosnabooking @endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-plus"></span> Dodaj auto</h1>
                </div>
            </div>
            <form action="{{asset("/insertcar")}}" method="post" class="formazadodat">
                <div class="row">
                    @csrf
                    <input type="hidden" name="jeledit" value="{{isset($acc)?$acc->id:0}}">
                    <div class="col-md-8 trrrr">
                        <div class="form-row mb-3">
                            <div class="col">
                                <label for="name"><span class="fa-fw fas fa-file-signature"></span> Name:</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                       @if(isset($acc)) value="{{$acc->name}}" @endif required>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-4">
                                <label for="type"><span class="fa-fw fas fa-certificate"></span> Type:</label>
                                <select name="type" id="type" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose type...</option>
                                    @foreach($subtypess as $s)
                                        <option value="{{$s->id}}" @if(isset($acc)) {{$acc->type==$s->id?"selected":""}} @endif >{{$s->ime}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="gorivo"><span class="fa-fw fas fa-gas-pump"></span> Fuel:</label>
                                <select name="gorivo" id="gorivo" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose fuel...</option>
                                    @foreach($gor as $s)
                                        <option value="{{$s->id}}" @if(isset($acc)) {{$acc->gorivo==$s->id?"selected":""}} @endif >{{$s->ime}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="cijena"><span class="fa-fw fas fa-euro"></span> 1-2 days</label>
                                <input id="cijena" name="cijena" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena}}" @endif required>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-4">
                                <label for="cijena2"><span class="fa-fw fas fa-euro"></span> 3-6 days</label>
                                <input id="cijena2" name="cijena2" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena2}}" @endif required>
                            </div>
                            <div class="col-md-4">
                                <label for="cijena3"><span class="fa-fw fas fa-euro"></span> 7 days</label>
                                <input id="cijena3" name="cijena3" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena3}}" @endif required>
                            </div>
                            <div class="col-md-4">
                                <label for="cijena4"><span class="fa-fw fas fa-euro"></span> 8-13 days</label>
                                <input id="cijena4" name="cijena4" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena4}}" @endif required>
                            </div>
                        </div>
                        <div class="form-row mb-2">
                            <div class="col-md-4">
                                <label for="cijena5"><span class="fa-fw fas fa-euro"></span> 14 days</label>
                                <input id="cijena5" name="cijena5" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena5}}" @endif required>
                            </div>
                            <div class="col-md-4">
                                <label for="cijena6"><span class="fa-fw fas fa-euro"></span> 15-20 days</label>
                                <input id="cijena6" name="cijena6" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena6}}" @endif required>
                            </div>
                            <div class="col-md-4">
                                <label for="cijena7"><span class="fa-fw fas fa-euro"></span> 21 days</label>
                                <input id="cijena7" name="cijena7" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena7}}" @endif required>
                            </div>
                        </div>
                        <div class="form-row mb-5">
                            <div class="col-md-3">
                                <label for="cijena8"><span class="fa-fw fas fa-euro"></span> 22+ days</label>
                                <input id="cijena8" name="cijena8" class="form-control" type="number" min="0" max="9999" step="0.01"
                                       @if(isset($acc)) value="{{$acc->cijena8}}" @endif required>
                            </div>
                            <div class="col-md-3">
                                <label for="brsjedista"><span class="fa-fw fas fa-hashtag"></span> Number of seats:</label>
                                <select name="brsjedista" id="brsjedista" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose...</option>
                                    @for($i=2;$i<11;$i++)
                                        <option value="{{$i}}" @if(isset($acc)) {{$acc->brsjedista==$i?"selected":""}} @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="kofkap"><span class="fa-fw fas fa-suitcase-rolling"></span> Bag capacity:</label>
                                <select name="kofkap" id="kofkap" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose...</option>
                                    @for($i=1;$i<13;$i++)
                                        <option value="{{$i}}" @if(isset($acc)) {{$acc->kofkap==$i?"selected":""}} @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="godine"><span class="fa-fw fas fa-address-card"></span> Minimum driver age:</label>
                                <select name="godine" id="godine" class="form-control oneba" required>
                                    <option value="" selected disabled hidden>Choose...</option>
                                    @for($i=15;$i<26;$i++)
                                        <option value="{{$i}}" @if(isset($acc)) {{$acc->godine==$i?"selected":""}} @endif>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mt-4 checkboxes-and-radios">
                        <div class="form-check">
                            <input type="checkbox" name="automatik" id="automatik" value="1" @if(isset($acc)) {{$acc->automatik?"checked":""}} @endif>
                            <label for="automatik"><span class="fa-fw fas fa-cogs"></span> Automatic transmission
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="klima" id="klima" value="1" @if(isset($acc)) {{$acc->klima?"checked":""}} @endif>
                            <label for="klima"><span class="fa-fw fas fa-snowflake"></span> Air condition
                            </label>
                        </div>
                        <div class="form-row mt-5 text-right">
                            <button type="submit" class="btn btn-block btn-lg hvzelena bgzuta">Next<span
                                        class="fa-fw fas fa-chevron-right"></span></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
