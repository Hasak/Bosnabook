<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 02/03/2019
 * Time: 00:50
 */
?>

        <!DOCTYPE html>
<html>
<head>
    <title>Voucher</title>
    <link rel="icon" href="{{asset("/img/core-img/fav.png")}}">
    <style>
        #sve{
            width: 100%;
        }
        img{
            width: 100%;
        }
        .desno{
            float: right;
        }
        .c{
            text-align: center;
        }
        .b{
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="sve">
    <img src="{{asset("/img/voucher.jpg")}}" alt="BosniaTravel">
    <p>
        BOSNIA TRAVEL d.o.o. Sarajevo<br>
        Licence number: 4201762290006<br><span class="desno">Datum/Date: {{date("d.m.Y.")}}</span>
        VAT Number: 201762290006<br>
        Address: DR. MUSTAFE PINTOLA 23<br>
        71210 ILIDŽA/SARAJEVO<br>
        BOSNA I HERCEGOVINA<br>
        Tel:+387 60 320 30 30<br><br>
        E-mail:	bosnatravel@gmail.com<span class="desno b">CIJENA/PRICE:{{$res->cijena}} €</span>
        <br><br>
        N/R:
    </p>
    <h2 class="c">Potvrda rezervacije br. / Booking confirmation No. 2019/{{$res->id}}</h2>
    <p>{{$sub->ime}}</p><hr>
    <p>
        {{$acc->name}}<br>
        Start date: {{date("d.m.Y.",strtotime($res->od))}} End date: {{date("d.m.Y.",strtotime($res->do))}}<br>
        Reservation Number: {{$res->id}}<br>
    </p>
    <hr>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p class="desno">
        ________________________<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Reservacije/Reservations<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mersed Softic<br>
    </p>
    <br><br><br><br><br><br>
    <p>
        Bosna Bank International BAM 141-309-53200003-19<br>
        IBAN/Account numer BA391413065310121016<br>
        Swift or Bic code : BBIBBA22XXX<br>
    </p>
</div>
</body>
</html>

