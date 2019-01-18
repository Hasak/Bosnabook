$('.input-daterange input').each(function() {
    //$(this).datepicker('clearDates');
    $(this).datepicker({
        format: "dd.mm.yyyy.",
        startDate: "d",
        maxViewMode: 0,
        multidate: 2,
        weekStart: 1,
        multidateSeparator: " — ",
        daysOfWeekHighlighted: "0,6",
        todayHighlight: true
    });
});
var pocdatc=$("#pocdatakima").val();
var kradatc=$("#kradatakima").val();
if(pocdatc!="" && kradatc!=""){
    var pp=new Date();
    var kk=new Date();
    pp.setTime(pocdatc*1000);
    kk.setTime(kradatc*1000);
    $("#dateee").datepicker('setDates', new Date(pp.getFullYear(),pp.getMonth(),pp.getDate()), new Date(kk.getFullYear(),kk.getMonth(),kk.getDate()));

}

$(".baboitema").click(function () {
    window.location.href=$(this).data("idina");
});
$(".baboitemarentt").click(function () {
    window.location.href=$(this).data("idina");
});
/*

$(".itemmm").click(function () {
    var t=$(this);
    $("#kojirentat").html(t.data("ime"));
    var cj=t.data("cijena");
    var id=t.data("id");
    $("#aid").val(id);
    $("#acj").val(cj);
    $("#nasbamodalauto").modal("show");

});
*/

$(document).ready(function(){
    $('.owl-carousel').owlCarousel();
    $("#dateee").datepicker("update");
});

function ukini() {
    $('#preloader').fadeOut('slow', function () {
        $(this).remove();
    });
}
setTimeout(ukini,2000);
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$("#submitter").click(function () {
    $("#trazi").submit();
});

$("#dateee").change(function () {
    function min(a,b) {
        if(a<b)
            return a;
        return b;
    }
    function max(a,b) {
        if(a>b)
            return a;
        return b;
    }
    if($("input[type=hidden][name=jelvlasnik]").val())
        return false;
    var sve=$(this).datepicker("getUTCDates");
    if(sve[0]==undefined && sve[1]==undefined){
        sve[0]=new Date();
        sve[1]=new Date();
    }
    else if(sve[0]==undefined && sve[1]!=undefined){
        sve[0]=sve[1];
    }
    else if(sve[0]!=undefined && sve[1]==undefined){
        sve[1]=sve[0];
    }
    var p=min(sve[0],sve[1]);
    var k=max(sve[0],sve[1]);
    var raz=k-p;
    //var cijeeena=$("#acj").val();
    // console.log(p);
    // console.log(k);
    var count=p.getTime();
    var iznos=0;
    //if(k==undefined)k=p;
    while(count<k.getTime()){
        var temp=new Date(count);
        var dfs=parseInt($("#acj"+(temp.getMonth()+1)).val());
        // console.log(dfs);
        iznos+=dfs;
        // console.log(iznos)
        count+=86400000;
    }
    /*
    var pd=p.getDay();
    var pm=p.getMonth()+1;
    var kd=k.getDay();
    var km=k.getMonth()+1;
*/
    //if(raz<0) raz=-raz;
    raz/=86400000;
    //var iznos = cijeeena*raz;
    if(isNaN(p) || isNaN(k))
        $("#minimaxinoci").html("");
    else $("#minimaxinoci").html(raz+" days = "+iznos.toFixed(2)+" €");
    if($(".masveba").eq(1).html()>raz) $("#minimaxinoci").addClass("text-danger");
    else $("#minimaxinoci").removeClass("text-danger");
});
function kojac(raz){
    if(raz>21) return 8;
    if(raz==21) return 7;
    if(raz>14) return 6;
    if(raz==14) return 5;
    if(raz>7) return 4;
    if(raz==7) return 3;
    if(raz>2) return 2;
    return "";
}
$(".dateeee").change(function () { /////////////// ZA AUTOOOOOOOOOOOOOO
    if($("input[type=hidden][name=jelvlasnik]").val())
        return false;
    var sve=$(this).datepicker("getUTCDates");
    var p=sve[0];
    var k=sve[1];
    if(isNaN(p))
        p=k;
    else if(isNaN(k))
        k=p;
    var raz=k-p;
    if(raz<0) raz=-raz;
    raz=raz/86400000+1;
    var cijeeena=$("#acj"+kojac(raz)).val();
    var iznos;
    if(raz===21 || raz===14 || raz===7)
        iznos=parseFloat(cijeeena);
    else iznos=cijeeena*raz;
    // console.log(cijeeena);
    // console.log(iznos+" "+raz+"\n");

    if(isNaN(p) && isNaN(k))
        $("#minimaxinoci").html("");
    else $("#minimaxinoci").html(raz+" days = "+iznos.toFixed(2)+" €");
    if($(".masveba").eq(1).html()>raz) $("#minimaxinoci").addClass("text-danger");
    else $("#minimaxinoci").removeClass("text-danger");
});

$("#trazi").submit(function (e) {
    e.preventDefault();
    var sve=$("#datee").datepicker("getUTCDates");
    var p=sve[0];
    var k=sve[1];
    var l=$("#wheree").val();
    var v=$("#whatt").val();
    var tok=$("input[name=_token]").val();
    $.ajax({
        method:"post",
        url: "/search",
        data:{start:p,end:k,location:l,vrsta:v,_token:tok},
        success:function (data) {
            window.location.href=data;
        },
        error:function (data) {
            //alert("Please choose");
            $("#nasbamodalpoc").modal("show");
        }
    });
    //console.log(p + "..." + k + "\n");
    return false;
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(".str").click(function () {

    var h=$("#haaa");
    var mm=h.parent().data("mjmin");
    mm++;
    mm--;
    var gm=h.parent().data("gdmin");
    var mmx=h.parent().data("mjmax");
    var gmx=h.parent().data("gdmax");
    var li=$(".str[data-gd='li']");
    var de=$(".str[data-gd='de']");
    // mmx--;
    // if(mmx===0){
    //     mmx=12;
    //     gmx--;
    // }

    // console.log(mm+" "+gm+" "+mmx+" "+gmx);
    var t=$(this);
    var k=$(".kalndri.a");
    var m=k.data("mje");
    var g=k.data("god");
    var gdje=t.data('gd');
    // console.log(m+" "+g+"\n");
    if(g===gm && mm===m && gdje==='li' || g===gmx && mmx===m && gdje==='de')
        return false;
    if(gdje==="li"){
        m--;
        if(m===0){
            m=12;
            g--;
        }
    }
    if(gdje==="de"){
        m++;
        if(m===13){
            m=1;
            g++;
        }
    }



    if(g===gm && mm===m){
        li.html("").removeClass("ptr");
    }
    else li.html("<span class='fas fa-chevron-left'></span>").addClass("ptr");
    if(g===gmx && mmx===m){
        de.html("").removeClass("ptr");
    }
    else de.html("<span class='fas fa-chevron-right'></span>").addClass("ptr");

    var s=$(".kalndri[data-mje='"+m+"'][data-god='"+g+"']");
    var mjes=h.parent().data("m"+m);

    h.fadeOut(150,function () {
        h.html("<span class='fa-fw far fa-calendar-alt'></span> "+mjes+", "+g);
        h.fadeIn(150);
    });
    k.fadeOut(150,function () {
        k.removeClass("a");
        s.fadeIn(150).addClass("a");
    });
    //console.log(m+" "+g+" "+t.data('gd')+" "+s);
});
var shklj=false;
var bbbb=$(".kar");
bbbb.on("keydown",function (e) {
    //alert(e.key);
    if(shklj && e.key!=="Backspace")return false;
    shklj=true;
});
bbbb.on("keyup",function () {
    shklj=false;
    var t=$(this);
    var ovaj=t.data("ja");
    if(t.val()>9999)
        t.val(t.val().substring(0,4));
    if(t.val()>999 && ovaj<4){
        ovaj++;
        $(".kar[data-ja='"+ovaj+"']").focus();
    }
    if(t.val()==="" && ovaj>0){
        ovaj--;
        $(".kar[data-ja='"+ovaj+"']").focus();
    }


    var pp=$(".kar").eq(0).val().substring(0,1);
    var gdjek=$("#kojakar");
    if(pp==3){
        var dp=$(".kar").eq(0).val().substring(1,2);
        if(dp==7)
            gdjek.html("<span class='fa-fw fab fa-cc-amex'></span>");
        else if(dp==8)
            gdjek.html("<span class='fa-fw fab fa-cc-diners-club'></span>");
        else gdjek.html("");
    }
    else if(pp==4){
        gdjek.html("<span class='fa-fw fab fa-cc-visa'></span>");
    }
    else if(pp==5){
        gdjek.html("<span class='fa-fw fab fa-cc-mastercard'></span>");
    }
    else if(pp==6){
        gdjek.html("<span class='fa-fw fab fa-cc-discover'></span>");
    }
    else{
        gdjek.html("");
    }
});
var shklj2=false;
var bbbbb=$("#cvv");
bbbbb.on("keydown",function (e) {
    //alert(e.key);
    if(shklj2 && e.key!=="Backspace")return false;
    shklj2=true;
});
bbbbb.on("keyup",function () {
    shklj2=false;
    var t=$(this);
    if(t.val()>9999)
        t.val(t.val().substring(0,4));
});


$("#bokform").submit(function (e) {
    e.preventDefault();
    var svee=$("#dateee").datepicker("getUTCDates");
    var p=svee[0];
    var k=svee[1];
    var al=$("#alerrt");
    var utu=$("#uturi");
    var a1=al;
    var raz=k-p;
    var cijeeena=$(".euroneuro").eq(0).parent().children().eq(0).html();
    if(raz<0) raz=-raz;
    raz/=86400000;
    $('#nasbamodal').animate({scrollTop:0}, "fast");
    var iznos = cijeeena*raz;
    var imevarijable=$("#adults");
    var ogbnrotvrf=$("#jelvl");
    var blaaaa=$(".masveba");
    if(imevarijable.length && imevarijable.val()==null){
        utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> You can not have zero adults! Are you crazy?");
        al.addClass("alert-danger").slideDown();
        return false;
    }
    if(isNaN(p) || isNaN(k)){
        utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> Choose correct date!");
        al.addClass("alert-danger").slideDown();
        return false;
    }
    if(imevarijable.length && blaaaa.eq(1).html()>raz){
        utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> Not enough nights!");
        al.addClass("alert-danger").slideDown();
        return false;
    }
    var s=$(this).serialize();
    var btns=$(".mdbtn");
    btns.attr("disabled","disabled");
    a1.slideUp("fast",function () {
        a1.removeClass("alert-warning").removeClass("alert-success").removeClass("alert-danger").addClass("alert-primary");
        var bla=ogbnrotvrf.val()=="" || ogbnrotvrf==null?" Booking...":" Closing dates...";
        utu.html("<span class='fa-fw fas fa-refresh fa-spin'></span>"+bla);
        a1.slideDown();
    });
    s+="&start="+p+"&end="+k;
    $.ajax({
        method: $(this).attr("method"),
        url: $(this).attr("action"),
        data: s,
        success:function (data) {
            btns.removeAttr("disabled");
            a1.slideUp("fast",function () {
                a1.removeClass("alert-primary");
                if(data==="dobaaar"){
                    $("#bokform").trigger("reset");
                    utu.html("<strong><span class='fa-fw fas fa-calendar-check-o'></span> Booked!</strong><br>Your booking successfully proceeded <span class='fa-fw fas fa-check'></span><br>We will contact you in next 24 hours on your E-mail address provided in the form <span class='fa-fw fas fa-envelope'></span>");
                    al.addClass("alert-success").slideDown();
                }
                else if(data==="dobaaaar"){
                    $("#bokform").trigger("reset");
                    utu.html("<strong><span class='fa-fw fas fa-calendar-check-o'></span> Closed!</strong><br>Dates were closed successfully <span class='fa-fw fas fa-check'></span>");
                    al.addClass("alert-success").slideDown();
                }
                else if(data==="reserved"){
                    utu.html("<strong><span class='fa-fw fas fa-calendar-times-o'></span> Already reserved!</strong><br>This period is already reserved. Try another one");
                    al.addClass("alert-warning").slideDown();
                }
                else if(data==="naaajts"){
                    utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> Not enough nights!");
                    al.addClass("alert-danger").slideDown();
                }
                else{
                    utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> "+data);
                    al.addClass("alert-danger").slideDown();
                }
            });
        },
        error:function (duda,data,dd) {
            btns.removeAttr("disabled");
            a1.slideUp("fast",function () {
                a1.removeClass("alert-primary");
                utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> "+data+": "+dd);
                al.addClass("alert-danger").slideDown();
            });

        }
    });
    //console.log(p + "..." + k + "\n");
    return false;
});


$(".oneba").change(function () {
    $(this).blur();
});


'use strict';

( function ( document, window, index )
{
    var inputs = document.querySelectorAll( '.inputfile' );
    Array.prototype.forEach.call( inputs, function( input )
    {
        var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                label.querySelector( 'span' ).innerHTML = fileName;
            else
                label.innerHTML = labelVal;
        });

        // Firefox bug fix
        input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
        input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    });
}( document, window, 0 ));

$(".btnslike").click(function (e) {
    e.preventDefault();
    var f=$("#formetina");
    var sta=$(this).data("koji");
    var path=$(this).data("path");
    var _token=$("input[name=_token]").val();
    var ajdi=$(this).data("josdate");
    $(".btnslike").attr("disabled","disabled");
    $.ajax({
        method: f.attr("method"),
        url: f.attr("action")+"e",
        data: {sta:sta,path:path,_token: _token},
        success:function (data) {
            if(sta==="brisi"){
                $("#slikic"+ajdi).fadeOut();
                $(".btnslike").removeAttr("disabled");
            }
            else{
                window.location.reload(true);
            }
        },
        error:function (duda,data,dd) {
            alert("Error: "+duda.responseText);
        }
    });
    return false;
});
$(".btnslikee").click(function (e) {
    e.preventDefault();
    var f=$("#formetina");
    var sta=$(this).data("koji");
    var path=$(this).data("path");
    var id=$(this).data("ide");
    var _token=$("input[name=_token]").val();
    //var ajdi=$(this).data("josdate");
    $(".btnslike").attr("disabled","disabled");
    $.ajax({
        method: f.attr("method"),
        url: f.attr("action")+"ee",
        data: {sta:sta,path:path,_token: _token,id:id},
        success:function (data) {
            window.location.reload();
        },
        error:function (duda,data,dd) {
            alert("Error: "+duda.responseText);
        }
    });
    return false;
});

$(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").click(function (e) {
    e.preventDefault();
    var t=$(this);
    var id=t.data("id");
    var sta=t.data("sta");
    var f=$("#formazaadmin");
    var tok=$("#formazaadmin input[name='_token']").val();
    $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").attr("disabled","disabled");
    $.ajax({
        method: f.attr("method"),
        url: f.attr("action"),
        data: {sta:sta,id:id,_token:tok},
        success:function (data) {
            if(sta==="izbrisi"){
                $(".zaresp[data-idr='"+id+"']").html("<td colspan='6'><em>Uspješno izbrisano!</em></td>");
            }
            else if(sta==="activiraj"){
                $(".zaact[data-idr='"+id+"']").html("<span class='gr'>Yes</span>");
                t.fadeOut();
            }
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        },
        error:function (duda,data,dd) {
            alert("Error: "+duda.responseText);
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        }
    });
    return false;
});


$(".butoninasizaadminadapozdravimhuguhugolinuimalehugicee").click(function (e) {
    e.preventDefault();
    var t=$(this);
    var id=t.data("id");
    var f=$("#formazaadmin");
    var tok=$("#formazaadmin input[name='_token']").val();
    $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").attr("disabled","disabled");
    $.ajax({
        method: f.attr("method"),
        url: f.attr("action"),
        data: {id:id,_token:tok},
        success:function (data) {
            $(".zaresp[data-idr='"+id+"']").html("<td colspan='5'><em>Uspješno izbrisano!</em></td>");
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        },
        error:function (duda,data,dd) {
            alert("Error: "+duda.responseText);
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        }
    });
    return false;
});


$(".butoninasizaadminadapozdravimhuguhugolinuimalehugiceee").click(function (e) {
    e.preventDefault();
    var t=$(this);
    var id=t.data("id");
    var f=$("#formazaadmin");
    var tok=$("#formazaadmin input[name='_token']").val();
    $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").attr("disabled","disabled");
    $.ajax({
        method: f.attr("method"),
        url: f.attr("action"),
        data: {id:id,_token:tok},
        success:function (data) {
            $(".zaresp[data-idr='"+id+"']").html("<td colspan='5'><em>Uspješno izbrisano!</em></td>");
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        },
        error:function (duda,data,dd) {
            alert("Error: "+duda.responseText);
            $(".butoninasizaadminadapozdravimhuguhugolinuimalehugice").removeAttr("disabled");
        }
    });
    return false;
});


$("#rentfrm").submit(function (e) {
    e.preventDefault();
    var svee=$("#dateee").datepicker("getUTCDates");
    var p=svee[0];
    var k=svee[1];
    var al=$("#alerrt");
    var utu=$("#uturi");
    var a1=al;
    var gfdslmr=$(".infsl");
    var ogbnrotvrf=$("#jelvl");
    $('#nasbamodalauto').animate({scrollTop:0}, "fast");
    /*
    if(!gfdslmr.eq(0).val() || !gfdslmr.eq(1).val() || !gfdslmr.eq(2).val()){
        a1.slideUp("fast",function () {
            a1.removeClass("alert-warning").removeClass("alert-success").addClass("alert-danger").removeClass("alert-primary");
            utu.html("<strong><span class='fa-fw fas fa-times'></span> Error: Attach all photos</strong>");
            a1.slideDown();
        });
        return false;
    }
    */
    if(isNaN(p) && isNaN(k)){
        utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> Choose correct date!");
        al.addClass("alert-danger").slideDown();
        return false;
    }

    if(isNaN(p) && !isNaN(k))
        p=k;
    if(!isNaN(p) && isNaN(k))
        k=p;

    var s=new FormData(this);
    s.append('start',p);
    s.append('end',k);
    var btns=$(".mdbtn");
    btns.attr("disabled","disabled");
    a1.slideUp("fast",function () {
        a1.removeClass("alert-warning").removeClass("alert-success").removeClass("alert-danger").addClass("alert-primary");
        var bla=ogbnrotvrf.val()=="" || ogbnrotvrf==null?" Renting...":" Closing dates...";
        utu.html("<span class='fa-fw fas fa-refresh fa-spin'></span>"+bla);
        a1.slideDown();
    });
    //s+="&start="+p+"&end="+k;
    $.ajax({
        method: $(this).attr("method"),
        url: $(this).attr("action"),
        processData: false,
        contentType: false,
        data: s,
        success:function (data) {
            btns.removeAttr("disabled");
            a1.slideUp("fast",function () {
                a1.removeClass("alert-primary");
                if(data==="dobaaar"){
                    $("#rentfrm").trigger("reset");
                    if(ogbnrotvrf.val()=="" || ogbnrotvrf==null)
                        utu.html("<strong><span class='fa-fw fas fa-car'></span> Rented!</strong><br>Your renting successfully proceeded <span class='fa-fw fas fa-check'></span><br>We will contact you in next 24 hours on your E-mail address provided in the form <span class='fa-fw fas fa-envelope'></span>");
                    else utu.html("<strong><span class='fa-fw fas fa-calendar-check-o'></span> Dates closed!</strong><br>Dates were closed successfully <span class='fa-fw fas fa-check'></span>");

                    al.addClass("alert-success").slideDown();

                }
                else{
                    utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> "+data);
                    al.addClass("alert-danger").slideDown();
                }
            });
        },
        error:function (duda,data,dd) {
            btns.removeAttr("disabled");
            a1.slideUp("fast",function () {
                a1.removeClass("alert-primary");
                utu.html("<strong><span class='fa-fw fas fa-times'></span> Error:</strong> "+data+": "+dd);
                al.addClass("alert-danger").slideDown();
            });

        }
    });
    //console.log(p + "..." + k + "\n");
    return false;
});

$(function() {

    var // Define maximum number of files.
        max_file_number = 50,
        // Define your form id or class or just tag.
        $form = $('#formetina'),
        // Define your upload field class or id or tag.
        $file_upload = $('#file-4', $form),
        // Define your submit class or id or tag.
        $button = $('#batntntn', $form);

    // Disable submit button on page ready.
    $button.prop('disabled', 'disabled');

    $file_upload.on('change', function () {
        var number_of_images = $(this)[0].files.length;
        if (number_of_images > max_file_number) {
            alert(`You can upload maximum ${max_file_number} photos per upload \nYou tried `+number_of_images+" photos");
            $(this).val('');
            $button.prop('disabled', 'disabled');
        } else {
            $button.prop('disabled', false);
        }
    });
});