@extends('sablon')
@section('title') Bosnabooking · Book a House or an Apartment @endsection
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
    <section class="dorne-welcome-area bg-img bg-overlay">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-12 col-md-10" id="pocsve">
                    <div class="hero-content">
                        <h2 style="text-align: center">Discover Bosnia with us</h2>
                        <h4 style="text-align: center">The best guide through Bosnia and Herzegovina</h4>
                    </div>
                    <div class="hero-search-form">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active bgplava" id="nav-places" role="tabpanel"
                                 aria-labelledby="nav-places-tab">
                                <h6>What are you looking for?</h6>
                                <form id="trazi" action="{{asset("/search")}}" method="post">
                                    {{csrf_field()}}
                                    <select id="wheree" name="gdjee" class="custom-select" required>
                                        <option disabled selected class="d-none">City</option>
                                        @foreach($mj as $mjesto)
                                            <option value="{{$mjesto->id}}">{{$mjesto->name}}</option>
                                        @endforeach
                                    </select>
                                    <select id="whatt" name="whatt" class="custom-select" required>
                                        <option disabled selected class="d-none">Type of accomodation</option>
                                        @foreach($subtypess as $mjesto)
                                            <option value="{{$mjesto->id}}"><i
                                                        class="{{$mjesto->icon}} fa-fw"></i> {{$mjesto->ime}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group input-daterange">
                                        <input data-date-start-date="0d" id="datee" name="whenn" type="text"
                                               class="form-control"
                                               value="Check In &amp; Check Out" autocomplete="off">
                                    </div>
                                </form>
                                <button id="submitter" class="btn dorne-btn bgzuta hvzelena"><i
                                            class="fas fa-search fa-fw pr-2"
                                            aria-hidden="true"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-social-btn">
            <div class="social-title d-flex align-items-center">
                <h6 id="zut">Follow us on Social Media</h6>
                <span class="bgzuta"></span>
            </div>
            <div class="social-btns">
                <a target="_blank" href="https://instagram.com/bosnia_travel?utm_source=ig_profile_share&igshid=cjrxihs1oowo"><i class="fab fa-fw fa-instagram zuta" aria-haspopup="true"></i></a>
                <a target="_blank" href="https://twitter.com/Bosnia_travel?s=08"><i class="fab fa-fw fa-twitter zuta" aria-haspopup="true"></i></a>
                <a target="_blank" href="https://www.facebook.com/Bosnia_travel-462407403950958/"><i class="fab fa-fw fa-facebook zuta" aria-haspopup="true"></i></a>
                <a target="_blank" href="https://www.youtube.com/channel/UCjegR29NXrhU5Fk4-WigySQ"><i class="fab fa-fw fa-youtube zuta" aria-haspopup="true"></i></a>
            </div>
        </div>
    </section>
    <section class="dorne-about-area section-padding-0-100">
        <div class="container">
            @php $i=1; @endphp
            <div class="row">
                @foreach($types as $t)
                    @php $ima=false; @endphp
                    @foreach($subtypes as $s)
                        @if($t->id==$s->typeid)
                            @php $ima=true; @endphp
                            @break
                        @endif
                    @endforeach
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="single-catagory-area wow fadeInUpBig br15" data-wow-delay="-0.5s">
                            <a href="{{$ima?asset("accomodation"):asset("")}}{{$ima?"/":""}}{{$t->link}}">
                                <div class="catagory-content ovo zuta">
                                    <span class="fas fa-fw {{$t->icon}} fa-4x"></span>
                                    <h5 class="mt-3 zuta">{{$t->ime}}</h5>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="dorne-features-destinations-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading dark text-center">
                        <h4 id="plav">Destinations in Bosnia and Herzegovina</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="features-slides owl-carousel">
                        @foreach($deest as $d)
                            <a href="{{asset("/destinations/".rijesi($d->ime)."/".$d->id)}}">
                                <div class="single-features-area br15">
                                    <img class="brr15 bbb1pxs" src="img/dest/{{$d->folder}}/main.jpg" alt="">
                                    <div class="price-start">
                                        <p class="br15 malotr">{{$d->plejs->name}}</p>
                                    </div>
                                    <div class="feature-content br15 d-flex align-items-center justify-content-between">
                                        <div class="feature-title br15">
                                            <h5 id="plav">{{$d->ime}}</h5>
                                            <p id="siv" class="bold">{{$d->plejs->plejsp->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="dorne-features-events-area bg-imgg bg-overlay-9 section-padding-100-50">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="shdw" id="cent">About us</h1>
                    <p class="shdw">
                        We are “Bosnia Travel” doo (Ltd), a travel agency from Sarajevo in Bosnia and Herzegovina. We
                        have
                        been dealing with tourist business since 2007, and we were officially registered in 2012. So far
                        we
                        have brought to Bosnia and Herzegovina many tourists from the Gulf countries.<br>

                        We can offer a comfortable accommodation in 4* and 5* hotels near big shopping centers. We can
                        be
                        proud of our log-year experience in business and the most favorable prices of accommodation and
                        transport. On annual level, we realize about 40,000 overnights, and for our tourists/guests, we
                        always choose the best excursions and the most interesting sightseeing places to be remembered
                        with
                        pleasure after going back home.
                    </p>
                    <p class="shdw">
                        We are ready for co-operation and organization of accommodation and travels for individuals,
                        families and larger touristic groups. We can also offer the spa services of healing and
                        rehabilitation by thermal-mineral water treatment. At the moment, we are co-operating with over
                        30
                        agencies from the UAE, Kuwait, the Kingdom of Saudi Arabia and some other GCC countries.
                    </p>
                    <p class="shdw">
                        Bosnia and Herzegovina is a beautiful country with rich history and great natural resources.
                        There
                        are numerous rivers and lakes, wonderful forests and magnificent mountains with lots of water
                        springs and waterfalls. Our spectacular rivers with unspoiled crystal-clear water offer great
                        conditions for rafting, kayaking, fishing, relaxing and enjoying. Stunning waterfalls,
                        breathtaking
                        canyons and rapids alternating with calm waters, make the country one of the top destinations
                        that
                        attracts a large number of visitors. Whichever part of the country you choose, it will be a good
                        decision and an exceptional experience. Furthermore, our hospitable, friendly and kind people
                        are
                        also one of the reasons that the number of tourists visiting Bosnia and Herzegovina has been
                        increased during recent years.
                    </p>
                    <p class="shdw">
                        Spa healing in Bosnia and Herzegovina – The tradition of using thermal-mineral waters in this
                        region
                        originates from the ancient times of Greeks and Romans who, even then, recognized the healing
                        properties of our geo-thermal springs.
                    </p>
                    <h5 class="shdw" id="cent">Our main office is in the popular complex of hotels “Hollywood” and
                        “Hills” (Ilidža – Sarajevo).</h5><br>
                    <p class="shdw">
                        We hope you will be one of our partners or guests.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="nasbamodalpoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{asset("/book")}}" method="post" id="bokform">
                <div class="modal-content w-100">
                    <div class="modal-header">
                        <h5 class="modal-title rd" id="jokba"><span
                                    class="fa-fw fas fa-times"></span>Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body c">
                        Please enter something to search
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection