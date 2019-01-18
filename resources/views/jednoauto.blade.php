<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 28/02/2019
 * Time: 23:31
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
    <link rel="stylesheet" href="{{asset("css/chc.css")}}">
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
@endsection

@php
    function rijesi($str){
        $str=str_ireplace("š","s",$str);
        $str=str_ireplace("đ","dj",$str);
        $str=str_ireplace("č","c",$str);
        $str=str_ireplace("ć","c",$str);
        $str=str_ireplace("ž","z",$str);
        $str=strtolower($str);
        $str=preg_replace('/\s+/', '', strtolower($str));
        return $str;
    }
@endphp
@section("title") {{$subtype}} · Bosnabooking @endsection
@section("content")
    <section class="property-area section-gap relative" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row">
                <div class="col header-text" style="margin-top: 25px;">
                    <h1><span class="fa-fw fas fa-car"></span> {{$subtype}}</h1>
                </div>
            </div>
            <div class="row bijelo mb-2 c">
                <div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Owner"><span
                                class="fas fa-user fa-fw"></span> {{$acc->kimin->username}}</span></div>
                <div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Type"><span
                                class="fas fa-certificate fa-fw"></span> {{$acc->tajp->ime}}</span>
                </div>
                <div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Location"><span
                                class="fas fa-map-marker-alt fa-fw"></span> Ilidža · Sarajevo</span></div>
            </div>
            <div class="row mt-5rem">
                <div class="col-lg-4">
                    <a class="box-1"
                       href="{{file_exists(public_path()."/img/auta/auto".$acc->id.".jpg")?asset("img/auta/auto".$acc->id.".jpg"):asset("img/noimagecar.jpg")}}"
                       data-toggle="lightbox" data-gallery="example-gallery">
                        <img id="maglavnaba"
                             src="{{file_exists(public_path()."/img/auta/auto".$acc->id.".jpg")?asset("img/auta/auto".$acc->id.".jpg"):asset("img/noimagecar.jpg")}}"
                             alt="Main Photo"
                             class="img-thumbnail zb mb-2 bn">
                    </a>
                    <h4 class="zuta c mt-2 mb-1"><span class="fa-fw fas fa-euro-sign"></span> Price list:</h4>
                    <table class="acctabela crtbl zuta table-sm table-responsive-lg">
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 1-2 days</td>
                            <td class="dsn">{{$acc->cijena}} &euro;/day</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 3-6 days</td>
                            <td class="dsn">{{$acc->cijena2}} &euro;/day</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 7 days</td>
                            <td class="dsn">{{$acc->cijena3}} &euro;</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 8-13 days</td>
                            <td class="dsn">{{$acc->cijena4}} &euro;/day</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 14 days</td>
                            <td class="dsn">{{$acc->cijena5}} &euro;</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 15-20 days</td>
                            <td class="dsn">{{$acc->cijena6}} &euro;/day</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 21 days</td>
                            <td class="dsn">{{$acc->cijena7}} &euro;</td>
                        </tr>
                        <tr>
                            <td class="ljv"><span class="fa-fw far fa-calendar-alt"></span> 22+ days</td>
                            <td class="dsn">{{$acc->cijena8}} &euro;/day</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-8">
                    <div class="row c vc mb-5 text-center">
                        <div class="col-lg-6">
                            @php $ii=0; $y="<span class='gr'>Yes</span>"; $n="<span class='rd'>No</span>" @endphp
                            <table class="acctabela crtbl zuta table-sm table-responsive-lg">
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-gas-pump"></span> Fuel:</td>
                                    <td class="dsn">{{$acc->gorivoo->ime}}</td>
                                </tr>
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-cogs"></span> Transmission:</td>
                                    <td class="dsn">{{$acc->automatik?"Automatic":"Manual"}}</td>
                                </tr>
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-snowflake"></span> Air condition:</td>
                                    <td class="dsn">{!!$acc->klima?$y:$n!!}</td>
                                </tr>
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-hashtag"></span> Number of seats:</td>
                                    <td class="dsn">{{$acc->brsjedista}}</td>
                                </tr>
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-suitcase-rolling"></span> Bag capacity:
                                    </td>
                                    <td class="dsn">{{$acc->kofkap}}</td>
                                </tr>
                                <tr>
                                    <td class="ljv"><span class="fa-fw fas fa-address-card"></span> Minimum driver age:
                                    </td>
                                    <td class="dsn">{{$acc->godine}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table border="1" class="tablee">
                                <thead>
                                @php
                                    $go=date("Y");
                                    $m=date("m");
                                    $d=date("d");
                                    $mjeseci=30;
                                    $mjeseci++;
                                    /*$go=2019;
                                    $m=10;
                                    $d=6;*/
                                @endphp
                                <tr>
                                    <th class="bnbnbn str" data-gd="li"></th>
                                    <th class="bnbnbn" colspan="5"
                                            @php
                                                $mmax=($mjeseci+1)%12;
                                                $gmax=$go+floor(($m+$mjeseci)/12);
                                                $m++;$m--;
                                                echo " data-mjmin='".$m."' data-gdmin='".$go."' data-mjmax='".$mmax."' data-gdmax='".$gmax."'";
                                                for($bb=1;$bb<13;$bb++)
                                                    echo " data-m".$bb."='".date("F",strtotime($go."-".$bb."-05"))."'";
                                            @endphp
                                    ><span id="haaa"><span
                                                    class="fa-fw far fa-calendar-alt"></span> {{date("F, Y",strtotime($go."-".$m."-".$d))}}</span>
                                    </th>
                                    <th class="bnbnbn str ptr" data-gd="de"><span class="fas fa-chevron-right"></span>
                                    </th>
                                </tr>
                                </thead>

                                @php
                                    function jelprijestupna($g){
                                        if($g%4==0){
                                            if($g%100==0){
                                                if($g%400==0){
                                                    return true;
                                                }
                                                else return false;
                                            }
                                            else return true;
                                        }
                                        else return false;
                                    }
                                    function bdum($m,$g){
                                        if($m==0||$m==1||$m==3||$m==5||$m==7||$m==8||$m==10||$m==12 || $m==13)
                                            return 31;
                                        else if($m==4||$m==6||$m==9||$m==11)
                                            return 30;
                                        else if($m==2)
                                            return jelprijestupna($g)?29:28;
                                        else return 1;
                                    }
                                    $m++;
                                    $m--;
                                    $pram=$m;
                                    $dani=array('M','T','W','T','F','S','S');
                                    for($k=0;$k<=$mjeseci;$k++){
                                        $m=$pram;
                                        $k?$s='s':$s='a';
                                        echo "<tbody class='kalndri $s' data-mje='$m' data-god='$go'><tr>";
                                        for($i=0;$i<7;$i++)
                                            echo "<td class='bnbnbn'>".$dani[$i]."</td>";
                                        echo "</tr>";
                                        $danprvi=date("N",strtotime($go."-".$m."-01"));
                                        if($danprvi=="1"){
                                            $inc=1;
                                            $pr='';
                                        }
                                        else{
                                            $m--;
                                            $inc=bdum($m,$go)-$danprvi+2;
                                            $pr='prm';
                                        }
                                        for($i=0;$i<5;$i++){
                                            echo "<tr>";
                                            for($j=0;$j<7;$j++){
                                                $zauz="";
                                                foreach ($res as $r){
                                                    $udat=date("Y-m-d",strtotime($go."-".$m."-".$inc));
                                                    if($udat>=$r->od and $udat<=$r->do){
                                                        //$zauz=$r->prihvaceno?'z':'za';
                                                        $zauz="z";
                                                        break;
                                                    }
                                                }
                                                echo "<td class='kockica $zauz $pr'>".$inc++."</td>";
                                                if($inc>bdum($m,$go)){
                                                    $m++;
                                                    $inc=1;
                                                    if($pr!='')
                                                        $pr='';
                                                    else $pr='prm';
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        echo "</tbody>";
                                        $pram++;
                                        if($m>12){
                                            $pram=1;
                                            $go++;
                                        }
                                    }
                                @endphp
                            </table>
                            <button class="btn nasbtn btn-outline-warning mt-3 mb-3" data-toggle="modal"
                                    data-target="#nasbamodalauto"><span
                                        class="fa-fw fas fa-calendar-check-o"></span> {{Auth::id()&&(Auth::user()->admin||$acc->owner==Auth::id()||Auth::user()->username=="Destination")?"Close dates":"Rent"}}
                            </button>
                        </div>
                        <div class="col-lg-4 offset-lg-1">
                            @if($mozel)
                                <button class="btn bgzuta hvzelena btn-block"
                                        onclick="window.location.href='{{asset('/edit/car/'.rijesi($subtype).'/'.$acc->id)}}'">
                                    <span class="fas fa-fw fa-edit"></span> Edit
                                </button>
                                <button class="btn bgzuta hvzelena btn-block"
                                        onclick="window.location.href='{{asset('/delete/car/'.rijesi($subtype).'/'.$acc->id)}}'">
                                    <span class="fas fa-fw fa-trash"></span> Delete
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="nasbamodalauto" tabindex="-1" role="dialog" aria-labelledby="nasbamodalili"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{asset("/rentt")}}" method="post" class="w-100" id="rentfrm" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title plava" id="nasbamodalili"><span
                                        class="fa-fw fas fa-car"></span>Rent: {{$acc->name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body plava">
                            <div id="alerrt" class="alert fade show s" role="alert">
                                <span id="uturi"></span>
                            </div>
                            @csrf
                            <input type="hidden" name="aid" id="aid" value="{{$acc->id}}">
                            <input type="hidden" name="jelvlasnik" value="{{Auth::id()&&(Auth::user()->admin||$acc->owner==Auth::id()||Auth::user()->username=="Destination")}}" id="jelvl">
                            <input type="hidden" name="acj" id="acj" value="{{$acc->cijena}}">
                            <input type="hidden" name="acj2" id="acj2" value="{{$acc->cijena2}}">
                            <input type="hidden" name="acj3" id="acj3" value="{{$acc->cijena3}}">
                            <input type="hidden" name="acj4" id="acj4" value="{{$acc->cijena4}}">
                            <input type="hidden" name="acj5" id="acj5" value="{{$acc->cijena5}}">
                            <input type="hidden" name="acj6" id="acj6" value="{{$acc->cijena6}}">
                            <input type="hidden" name="acj7" id="acj7" value="{{$acc->cijena7}}">
                            <input type="hidden" name="acj8" id="acj8" value="{{$acc->cijena8}}">
                            @if(!Auth::id() or !Auth::user()->admin and $acc->owner!=Auth::id() and Auth::user()->username!="Destination")
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="imee"><span class="fa-fw fas fa-user"></span> Name:</label>
                                        <input name="name" id="imee" placeholder="Please enter your name" type="text"
                                               class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label for="pimee"><span class="fa-fw fas fa-users"></span> Surame:</label>
                                        <input name="surname" id="pimee" placeholder="Please enter your surname"
                                               type="text"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="phonee"><span class="fa-fw fas fa-mobile-alt"></span> Phone number:</label>
                                        <input name="phone" id="phonee" placeholder="Please enter your name" type="tel"
                                               class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label for="emaiil"><span class="fa-fw fas fa-at"></span> Email address:</label>
                                        <input name="email" id="emaiil" placeholder="Please enter your surname"
                                               type="email"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="drzz"><span class="fa-fw fas fa-globe-europe"></span>
                                            Country:</label>
                                        <select name="drzz" id="drzz" class="form-control ptr" required>
                                            <option value="0" selected hidden disabled>Choose country</option>
                                            @php $i=0; @endphp;
                                            @foreach($drz as $d)
                                                <option value="{{$d->id}}">{{$d->puno}}</option>
                                                @if($drz[$i]->jeluprvim and !$drz[$i+++1]->jeluprvim)
                                                    <option value="0" disabled>━━━━━━━━━━━━━━━━━━━━━━━━━</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="dob"><span class="fa-fw fas fa-calendar-day"></span> Birth
                                            date:</label>
                                        <input name="dob" id="dob" placeholder="Birth date (DD/MM/YYYY)" type="text"
                                               class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label for="loc"><span class="fa-fw fas fa-map-marker-alt"></span> Pickup
                                            location:</label>
                                        <select name="loc" id="loc" class="form-control ptr" required>
                                            <option value="" selected hidden disabled>Choose location</option>
                                            <option value="0">Sarajevo office</option>
                                            <option value="1">Sarajevo airport</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label><span class="fa-fw fas fa-file-photo-o"></span> Attach photos
                                            (.jpg):</label><br>
                                        <input type="file" name="slika1" id="file-1"
                                               class="inputfile infsl szzft inputfile-1">
                                        <label for="file-1"><i class="fa-fw fas fa-address-card"></i>
                                            <span>ID</span></label><br>

                                        <input type="file" name="slika2" id="file-2"
                                               class="inputfile infsl szzft inputfile-2">
                                        <label for="file-2"><i class="fa-fw far fa-address-book"></i>
                                            <span>Licence</span></label><br>

                                        <input type="file" name="slika3" id="file-3"
                                               class="inputfile infsl szzft inputfile-3">
                                        <label for="file-3"><i class="fa-fw far fa-address-card"></i>
                                            <span>Passport</span></label>
                                    </div>
                                    <div class="col checkboxes-and-radios">
                                        <label><span class="fa-fw fas fa-asterisk"></span> Options:</label>
                                        <div class="form-check ml-3">
                                            <input type="checkbox" name="gps" id="gps" value="1">
                                            <label for="gps"><span class="fa-fw fas fa-satellite"></span> GPS</label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="checkbox" name="picnic" id="picnic" value="1">
                                            <label for="picnic"><span class="fa-fw fas fa-campground"></span> Picnic set</label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input type="checkbox" name="cseat" id="cseat" value="1">
                                            <label for="cseat"><span class="fa-fw fas fa-baby"></span> Child
                                                seat</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-row mb-3">
                                <div class="col">
                                    <div class="input-daterange">
                                        <label for="dateee"><span class="fa-fw far fa-calendar-alt"></span> Renting
                                            Dates:</label>
                                        <span id="minimaxinoci" class="bold pull-right"></span>
                                        <input data-date-start-date="0d" id="dateee" type="text"
                                               class="form-control ptr dateeee"
                                               value="Renting Dates" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            @if(!Auth::id() or !Auth::user()->admin and $acc->owner!=Auth::id() and Auth::user()->username!="Destination")
                                <div class="form-row">
                                    <div class="col">
                                        <label for="kar0"><span class="fa-fw far fa-credit-card"></span> Credit card
                                            number:</label>
                                        <span id="kojakar" class="pull-right"></span>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">

                                        <input name="kar0" data-ja="0" id="kar0" maxlength="4" pattern="\d*"
                                               class="form-control kar" min="0" max="9999" type="number" required>
                                    </div>
                                    <div class="col">
                                        <label for="kar1" class="d-none"></label>
                                        <input name="kar1" data-ja="1" id="kar1" maxlength="4" pattern="\d*"
                                               class="form-control kar" min="0" max="9999" type="number" required>
                                    </div>
                                    <div class="col">
                                        <label for="kar2" class="d-none"></label>
                                        <input name="kar2" data-ja="2" id="kar2" maxlength="4" pattern="\d*"
                                               class="form-control kar" min="0" max="9999" type="number" required>
                                    </div>
                                    <div class="col">
                                        <label for="kar3" class="d-none"></label>
                                        <input name="kar3" data-ja="3" id="kar3" maxlength="4" pattern="\d*"
                                               class="form-control kar" min="0" max="9999" type="number" required>
                                    </div>
                                    <div class="col">
                                        <label for="kar4" class="d-none"></label>
                                        <input name="kar4" data-ja="4" id="kar4" maxlength="4" pattern="\d*"
                                               class="form-control kar" min="0" max="9999" type="number" required>
                                    </div>
                                </div>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label for="cvv"><span class="fa-fw fas fa-lock"></span> CVV:</label>
                                        <input name="cvv" id="cvv" maxlength="4" pattern="\d*"
                                               class="form-control karr" min="0" max="9999" type="number" required>
                                    </div>
                                    <div class="col">
                                        <label for="expm"><span class="fa-fw fas fa-calendar-alt"></span> Exp.
                                            MM:</label>
                                        <select name="expm" id="expm" class="form-control ptr" required>
                                            <option value="" selected disabled hidden>Month</option>
                                            @for($i=1;$i<13;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="expg"><span class="fa-fw fas fa-calendar"></span> Exp. YY:</label>
                                        <select name="expg" id="expg" class="form-control ptr" required>
                                            <option value="" selected disabled hidden>Year</option>
                                            @for($i=date("Y");$i<date("Y")+10;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="textonja"><span class="fa-fw fas fa-sticky-note"></span>
                                            Notes:</label>
                                        <textarea name="textonja" class="form-control" id="textonja" rows="4"
                                                  placeholder="If you have any additional notes for us, enter them here..."></textarea>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="ptr mdbtn btn bgsiva cb hvplava"><span
                                        class="fas fa-fw fa-undo"></span> Reset
                            </button>
                            <button type="submit" class="ptr mdbtn btn bgzuta cb hvzelena"><span
                                        class="fa-fw fas fa-check"></span> Rent
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
