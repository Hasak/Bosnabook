<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 18/02/2019
 * Time: 19:26
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
@section("title") Admin Panel · Bosnabooking @endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-cog fa-spin"></span> Admin Panel</h1>
                </div>
            </div>
            <form action="{{asset("/adminchange")}}" method="post" id="formazaadmin">
                <div class="row">
                    @csrf
                    <div class="col">
                        <table class="table table-hover" id="tabelatabela">
                            <thead>
                            <tr>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-hashtag"></span> ID</th>
                                <th><span class="fa-fw fas fa-user"></span> Username</th>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-user-secret"></span> Admin</th>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-user-plus"></span> Active</th>
                                <th class="d-none d-md-table-cell"><span class="fa-fw fas fa-calendar-check-o"></span> Date</th>
                                <th><span class="fa-fw fas fa-certificate"></span> Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $y="<span class='gr'>Yes</span>"; $n="<span class='rd'>No</span>" @endphp
                            @foreach($users as $u)
                                <tr class="zaresp" data-idr="{{$u->id}}">
                                    <td class="d-none d-md-table-cell">{{$u->id}}</td>
                                    <td>{{$u->username}}</td>
                                    <td class="d-none d-md-table-cell">{!!$u->admin?$y:$n!!}</td>
                                    <td class="d-none d-md-table-cell" class="zaact" data-idr="{{$u->id}}">{!!$u->active?$y:$n!!}</td>
                                    <td class="d-none d-md-table-cell">{{date("d.m.Y. @ G:i",strtotime($u->created_at))}}</td>
                                    <td>
                                        @if(!$u->active)
                                            <button data-sta="activiraj" data-id="{{$u->id}}" class="btn btn-sm zel butoninasizaadminadapozdravimhuguhugolinuimalehugice mt-1"><span class="fa-fw fas fa-check"></span> Potvrdi</button>
                                        @endif
                                        <button data-sta="izbrisi" data-id="{{$u->id}}" class="btn btn-sm crv butoninasizaadminadapozdravimhuguhugolinuimalehugice mt-1"><span class="fa-fw fas fa-trash"></span> Izbriši</button>
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
