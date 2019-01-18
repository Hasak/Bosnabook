<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 19/03/2019
 * Time: 14:03
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
    <link rel="stylesheet" href="{{asset("css/animate.css")}}">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("/css/chc.css")}}">
@endsection
@section("title") Reservations · Bosnabooking @endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-calendar-check-o"></span> Reservations</h1>
                </div>
            </div>
            <form action="{{asset("/reschange")}}" method="post" id="formazaadmin">
                <div class="row">
                    @csrf
                    <div class="col">
                        <table class="table table-hover table-sm" id="tabelatabela">
                            <thead>
                            <tr>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-hashtag"></span> ID</th>
                                <th><span class="fa-fw fas fa-home"></span> Accomodation
                                </th>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-user"></span> Name</th>
                                <th><span class="fa-fw far fa-calendar-alt"></span> Date
                                </th>
                                <th><span class="fa-fw fas fa-certificate"></span> <span class="d-none d-md-inline">Action</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $y="<span class='gr'>Yes</span>"; $n="<span class='rd'>No</span>" @endphp
                            @foreach($users as $u)
                                <tr class="zaresp" data-idr="{{$u->id}}">
                                    <td class="d-none d-md-table-cell">{{$u->id}}</td>
                                    <td>{{$u->accc->name}}</td>
                                    <td class="d-none d-md-table-cell">{!!$u->gname?"<span class='bold'>".$u->gname." ".$u->gsurname."</span>":"<span class='text-italic'>Closed dates</span>"!!}</td>
                                    <td>{{date("d.m.Y",strtotime($u->od))." – ".date("d.m.Y",strtotime($u->do))}}</td>
                                    <td>
                                        <button data-sta="izbrisi" data-id="{{$u->id}}"
                                                class="btn btn-sm crv butoninasizaadminadapozdravimhuguhugolinuimalehugicee mt-1">
                                            <span class="fa-fw fas fa-trash"></span> <span
                                                    class="d-none d-md-inline">Izbriši</span></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

