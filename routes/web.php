<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Akomodejsns;
use App\Auto;
use App\Destt;
use App\Rent;
use App\Reserved;
use App\Subtype;
use App\User;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

Auth::routes();

Route::get('/',function(){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$subtypess=DB::table("subtypeacc")->get();
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$deest=Destt::inRandomOrder()->get();
	return view('welcome',compact("types","deest","subtypes","mj","subm","subtypess"));
});

Route::get('accomodation/{type}/{subtype}/{place}/{start}/{end}',function($type,$subtype,$place,$start,$end){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$huha=DB::table("subtypeacc")->where("link",$subtype)->value("ime");
	if(!$huha)
		abort(404);
	$idsuba=DB::table("subtypeacc")->where("link",$subtype)->first();
	$ikon=$idsuba->icon;
	$subtype=$huha;
	///////////////////////////////////////////////////////////
	$placeid=DB::table("places")->where("link",$place)->first();
	if(!$placeid)
		abort(404);
	$poc=min(strtotime($start),strtotime($end));
	$kra=max(strtotime($start),strtotime($end));
	$brnoc=($kra-$poc)/86400;
	$ldp=date("Y-m-d",$poc);
	$ldk=date("Y-m-d",$kra);
	$dp=date("d.m.Y",$poc);
	$dk=date("d.m.Y",$kra);
	//dd($ldp);
	$ssub=DB::table("subplaces")->where("placeid",$placeid->id)->pluck("id");
	$acc=Akomodejsns::where("subtype",$idsuba->id)->whereIn("place",$ssub)->where("izb","0")->where("minimumNumberOfNights","<=",$brnoc)->get();
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$c=$poc;
		$iznos[$a->id]=0;
		while($c<$kra){
			$imevar="price".date("F",$c);
			$iznos[$a->id]+=$a->$imevar;
			$c+=86400;
		}
		$zauzeto[$a->id]=false;
		$datumi=DB::table("reserved")->where("accid",$a->id,"izbrisano",false)->get();
		foreach($datumi as $datum){
			if(($ldp<=$datum->od&&$ldk>=$datum->do)||($ldp>=$datum->od&&$ldp<$datum->do||$ldk>$datum->od&&$ldk<=$datum->do))
				$zauzeto[$a->id]=true;
		}
	}
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	return view('acc',compact("types","subtypes","subtype","ikon","iznos","acc","mj","subm","zauzeto","iznos","dp","dk"));
})->where("place","[a-z]+");

Route::get('accomodation/all/{start}/{end}',function($start,$end){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$subtype="All accomodations";
	$ikon="fas fa-certificate";
	$poc=min(strtotime($start),strtotime($end));
	$kra=max(strtotime($start),strtotime($end));
	$dp=date("d.m.Y",$poc);
	$dk=date("d.m.Y",$kra);
	$brnoc=($kra-$poc)/86400;
	///////////////////////////////////////////////////////////
	$ldp=date("Y-m-d",$poc);
	$ldk=date("Y-m-d",$kra);
	$acc=Akomodejsns::where("izb","0")->where("minimumNumberOfNights","<=",$brnoc)->get();
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$c=$poc;
		$iznos[$a->id]=0;
		while($c<$kra){
			$imevar="price".date("F",$c);
			$iznos[$a->id]+=$a->$imevar;
			$c+=86400;
		}
		$zauzeto[$a->id]=false;
		$datumi=DB::table("reserved")->where("accid",$a->id,"izbrisano",false)->get();
		foreach($datumi as $datum){
			if(($ldp<=$datum->od&&$ldk>=$datum->do)||($ldp>=$datum->od&&$ldp<$datum->do||$ldk>$datum->od&&$ldk<=$datum->do))
				$zauzeto[$a->id]=true;
		}
	}
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	return view('acc',compact("types","subtypes","subtype","ikon","acc","mj","subm","zauzeto","iznos","dp","dk"));
});

Route::get('accomodation/{name}/{accid}/{dp?}/{dk?}',function($name,$accid,$dp=null,$dk=null){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=Akomodejsns::where("id",$accid)->where("izb",0)->first(); //  da li ovjde zabranit ako je izbrisana?
	if(!$acc)
		abort(404);
	$subtype=DB::table("accs")->where("id",$accid)->value("name");
	$ikon=DB::table("subtypeacc")->where("id",$acc->subtype)->value("icon");
	$cols=Schema::getColumnListing("accs");
	$cols=array_slice($cols,9);
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$ikone=DB::table("ikone")->get();
	$users=DB::table("users")->get();
	$drz=DB::table("drzave")->orderBy("jeluprvim","desc")->get();
	$res=DB::table("reserved")->where("accid",$accid)->where("izbrisano",false)->orderBy("prihvaceno","desc")->get();
	$resad=DB::table("reserved")->where("accid",$accid)->where("izbrisano",false)->where("userid","!=",null)->get();
	/////////////////////////////////////////////////////////////////////////////////////////////
	$mozel=Auth::user()&&(Auth::user()->admin||Auth::id()==$acc->owner);
	/////////////////////////////////////////////////////////////////////////////////////////////
	///
	//dd(Auth::id()==$acc->owner);
	$i=0;
	foreach($cols as $col){
		$tajpovi[$i++]=DB::connection()->getDoctrineColumn("accs",$col)->getType()->getName();
	}
	//dd($dp,$dk);
	return view('jedno',compact("types","subtypes","drz","resad","mozel","res","ikon","ikone","tajpovi","users","acc","mj","subm","subtype","cols","dp","dk"));
})->where("accid","[0-9]+");

Route::get('accomodation/{type}/{subtype}/{start}/{end}',function($type,$subtype,$start,$end){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$huha=DB::table("subtypeacc")->where("link",$subtype)->value("ime");
	if(!$huha)
		abort(404);
	$idsuba=DB::table("subtypeacc")->where("link",$subtype)->first();
	$ikon=$idsuba->icon;
	$subtype=$huha;
	$poc=min(strtotime($start),strtotime($end));
	$kra=max(strtotime($start),strtotime($end));
	$dp=date("d.m.Y",$poc);
	$dk=date("d.m.Y",$kra);
	$brnoc=($kra-$poc)/86400;
	///////////////////////////////////////////////////////////
	$ldp=date("Y-m-d",$poc);
	$ldk=date("Y-m-d",$kra);
	//dd($ldp);
	$acc=Akomodejsns::where("subtype",$idsuba->id)->where("izb","0")->where("minimumNumberOfNights","<=",$brnoc)->get();

	//dd($acc);
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$c=$poc;
		$iznos[$a->id]=0;
		while($c<$kra){
			$imevar="price".date("F",$c);
			$iznos[$a->id]+=$a->$imevar;
			$c+=86400;
		}
		$zauzeto[$a->id]=false;
		$datumi=DB::table("reserved")->where("accid",$a->id,"izbrisano",false)->get();
		foreach($datumi as $datum){
			if(($ldp<=$datum->od&&$ldk>=$datum->do)||($ldp>=$datum->od&&$ldp<$datum->do||$ldk>$datum->od&&$ldk<=$datum->do))
				$zauzeto[$a->id]=true;
		}
	}
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	return view('acc',compact("types","subtypes","subtype","ikon","acc","mj","subm","zauzeto","iznos","dp","dk"));
});

Route::get('accomodation/{type}/{subtype}/{place}',function($type,$subtype,$place){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$tajponja=DB::table("typeacc")->where("link",$type)->first();
	//dd($tajponja);
	$mjestonja=DB::table("places")->where("link",$type)->first();
	if($tajponja){
		$huha=DB::table("subtypeacc")->where("link",$subtype)->value("ime");
		if(!$huha)
			abort(404);
		$idsuba=DB::table("subtypeacc")->where("link",$subtype)->first();
		$ikon=$idsuba->icon;
		$subtype=$huha;
		///////////////////////////////////////////////////////////
		$placeid=DB::table("places")->where("link",$place)->first();
		if(!$placeid)
			abort(404);
		//dd($ldp);
		$ssub=DB::table("subplaces")->where("placeid",$placeid->id)->pluck("id");
		$iznos[]=0;
		$acc=Akomodejsns::where("subtype",$idsuba->id)->whereIn("place",$ssub)->where("izb","0")->get();
		$dp=null;
		$dk=null;
		$zauzeto=false;
		$iznos[]=0;
		foreach($acc as $a){
			$imevar="price".date("F");
			$iznos[$a->id]=$a->$imevar;
		}
	}else if($mjestonja){
		$ssub=DB::table("subplaces")->where("placeid",$mjestonja->id)->pluck("id");
		$ikon="fas fa-map-marker-alt";
		$poc=min(strtotime($subtype),strtotime($place));
		$kra=max(strtotime($subtype),strtotime($place));
		$dp=date("d.m.Y",$poc);
		$dk=date("d.m.Y",$kra);
		$brnoc=($kra-$poc)/86400;
		$acc=Akomodejsns::whereIn("place",$ssub)->where("izb","0")->where("minimumNumberOfNights",">=",$brnoc)->get();
		$ldp=date("Y-m-d",$poc);
		$ldk=date("Y-m-d",$kra);
		$zauzeto=false;
		$iznos[]=0;
		foreach($acc as $a){
			$c=$poc;
			$iznos[$a->id]=0;
			while($c<$kra){
				$imevar="price".date("F",$c);
				$iznos[$a->id]+=$a->$imevar;
				$c+=86400;
			}
			$zauzeto[$a->id]=false;
			$datumi=DB::table("reserved")->where("accid",$a->id)->where("izbrisano",false)->get();
			foreach($datumi as $datum){
				if(($ldp<=$datum->od&&$ldk>=$datum->do)||($ldp>=$datum->od&&$ldp<$datum->do||$ldk>$datum->od&&$ldk<=$datum->do))
					$zauzeto[$a->id]=true;
			}
		}
		$subtype=$mjestonja->name;
	}else abort(404);
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	return view('acc',compact("types","subtypes","subtype","ikon","acc","mj","subm","zauzeto","iznos","dp","dk"));
});

Route::get('accomodation/{type}/{subtype}',function($type,$subtype){
	$sid=DB::table("subtypeacc")->where("link",$subtype)->value("id");
	if(!$sid)
		abort(404);
	$huha=Subtype::where("link",$subtype)->value("ime");
	$ikon=Subtype::where("link",$subtype)->value("icon");
	$subtype=$huha;
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=Akomodejsns::where("subtype",$sid)->where("izb","0")->get();
	//$acc = Akomodejsns::where("subtype", $sid)->where("izb", "0")->join("subplaces","subplaces.id","=","accs.place")->join("places","places.id","=","subplaces.placeid")->orderBy("places.name")->get();
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$imevar="price".date("F");
		$iznos[$a->id]=$a->$imevar;
	}
	//dd($acc);
	return view('acc',compact("types","subtypes","acc","ikon","mj","subm","subtype","zauzeto","iznos"));
});

Route::get('accomodation/{type}',function($type){
	$ty=DB::table("typeacc")->where("link",$type)->first();
	$tid=$ty?$ty->id:null;
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	if($tid){
		$huha=$ty->ime;
		$ikon=$ty->icon;
		$subtype=$huha;
		$ssub=DB::table("subtypeacc")->where("typeid",$tid)->pluck("id");
		$acc=Akomodejsns::whereIn("subtype",$ssub)->where("izb","0")->get();
	}else{
		$gid=DB::table("places")->where("link",$type)->first();
		if(!$gid)
			abort(404);
		$ikon="fas fa-map-marker-alt";
		$plcc=DB::table("subplaces")->where("placeid",$gid->id)->pluck("id");
		$acc=Akomodejsns::whereIn("place",$plcc)->where("izb","0")->get();
		$subtype=$gid->name;
	}
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$imevar="price".date("F");
		$iznos[$a->id]=$a->$imevar;
	}
	return view('acc',compact("types","subtypes","acc","ikon","mj","subm","subtype","zauzeto","iznos"));
});

Route::get('accomodation',function(){
	//$tid = DB::table("typeacc")->where("link", $type)->value("id");
	//$huha = DB::table("typeacc")->where("link", $type)->value("ime");
	$subtype="My Accomodations"; //$huha;
	//$ssub = DB::table("subtypeacc")->where("typeid", $tid)->pluck("id");
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$ikon="fas fa-home";
	if(!Auth::user())
		abort(403);
	$us=User::find(Auth::id());
	if($us->admin)
		$acc=Akomodejsns::where("izb","0")->get();
	else $acc=Akomodejsns::where("izb","0")->where("owner",$us->id)->get();
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$zauzeto=false;
	$iznos[]=0;
	foreach($acc as $a){
		$imevar="price".date("F");
		$iznos[$a->id]=$a->$imevar;
	}
	return view('acc',compact("types","subtypes","acc","ikon","mj","subm","subtype","zauzeto","iznos"));
});

Route::get('car/{name}/{accid}',function($name,$accid){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=Auto::where("id",$accid)->where("izbrisano",0)->first(); //  da li ovjde zabranit ako je izbrisana?
	if(!$acc)
		abort(404);

	$subtype=$acc->name;
	/*$ikon=DB::table("subtypeacc")->where("id", $acc->subtype)->value("icon");
    $cols = Schema::getColumnListing("accs");
    $cols = array_slice($cols, 9);
    $mj = DB::table("places")->get();
    $subm = DB::table("subplaces")->get();
    $ikone = DB::table("ikone")->get();
    $users = DB::table("users")->get();
    */
	$res=DB::table("rented")->where("carid",$accid)->where("izbrisano",false)->where("userid","!=",null)->get();
	$drz=DB::table("drzave")->orderBy("jeluprvim","desc")->get();
	/////////////////////////////////////////////////////////////////////////////////////////////
	$mozel=Auth::user()&&(Auth::user()->admin||Auth::id()==$acc->owner||Auth::user()->username=="Destination");
	/////////////////////////////////////////////////////////////////////////////////////////////
	///
	//dd(Auth::id()==$acc->owner);
	return view('jednoauto',compact('types','subtype','subtypes','acc','res','mozel','drz'));
	//return view('jedno', compact("types", "subtypes", "drz","mozel", "res","ikon", "ikone", "tajpovi", "users", "acc", "mj", "subm", "subtype", "cols"));
})->where("accid","[0-9]+");

Route::get('rentacar',function(){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$rent=Auto::where("izbrisano",0)->get();
	$fuel=DB::table("goriva")->get();
	$tipovi=DB::table("autatypes")->get();
	$drz=DB::table("drzave")->orderBy("jeluprvim","desc")->get();
	$title="Rent-a-car";
	return view('rent',compact("types","subtypes","rent","fuel","tipovi","title","drz"));
});

Route::post('search',function(){
	$uz=substr(request("start"),4,11);
	$uz2=substr(request("end"),4,11);
	$p=date("d.m.Y",min(strtotime($uz),strtotime($uz2)));
	$k=date("d.m.Y",max(strtotime($uz),strtotime($uz2)));
	if(!request("vrsta") and !request("location") and $p=="01.01.1970"){
		abort(404);
	}
	if(!request("vrsta") and !request("location")){
		return "/accomodation/all/".$p."/".$k;
	}
	if(!request("location")){
		$subtypes=DB::table("subtypeacc")->where("id",request("vrsta"))->first();
		if(!$subtypes)
			abort(404);
		$types=DB::table("typeacc")->where("id",$subtypes->typeid)->first();
		if($p=="01.01.1970")
			return "/accomodation/".$types->link."/".$subtypes->link;
		return "/accomodation/".$types->link."/".$subtypes->link."/".$p."/".$k;
	}
	if(!request("vrsta")){
		$mj=DB::table("places")->where("id",request("location"))->first();
		if(!$mj)
			abort(404);
		if(!request("vrsta")){
			if($p=="01.01.1970")
				return "/accomodation/".$mj->link;
			return "/accomodation/".$mj->link."/".$p."/".$k;
		}
	}
	$mj=DB::table("places")->where("id",request("location"))->first();
	if(!$mj)
		abort(404);
	$subtypes=DB::table("subtypeacc")->where("id",request("vrsta"))->first();
	if(!$subtypes)
		abort(404);
	$types=DB::table("typeacc")->where("id",$subtypes->typeid)->first();
	if($p=="01.01.1970")
		return "/accomodation/".$types->link."/".$subtypes->link."/".$mj->link;
	return "/accomodation/".$types->link."/".$subtypes->link."/".$mj->link."/".$p."/".$k;
});

Route::post("book",function(){
	$acid=request("acid");
	$acc=DB::table("accs")->where("id",$acid)->where("izb",0)->first();
	if(!$acc)
		abort(404);
	$ime=DB::table("accs")->where("id",$acid)->value("name");
	$uz=substr(request("start"),4,11);
	$uz2=substr(request("end"),4,11);
	$odd=min(strtotime($uz),strtotime($uz2));
	$doo=max(strtotime($uz),strtotime($uz2));
	$iznos=0;
	$c=$odd;
	while($c<$doo){
		$imevar="price".date("F",$c);
		$iznos+=$acc->$imevar;
		$c+=86400;
	}
	$noci=($doo-$odd)/86400;
	$p=date("Y-m-d",$odd);
	$k=date("Y-m-d",$doo);
	if(request("jelvlasnik") or (Auth::id() and Auth::user()->admin)){
		if(!Auth::id() and $acc->owner!=Auth::id() and !(Auth::id() and Auth::user()->admin))
			abort(403);
		$bla=new Reserved;
		$bla->accid=$acid;
		$bla->od=$p;
		$bla->do=$k;
		$bla->userid=Auth::id();
		$bla->prihvaceno=true;
		$bla->izbrisano=false;
		$bla->ccode=md5(uniqid(rand(),true));
		$bla->hashh=md5(uniqid(rand()/7,true));
		$bla->save();
		return "dobaaaar";
	}
	if($noci<$acc->minimumNumberOfNights and !(request("jelvlasnik") or (Auth::id() and Auth::user()->admin)))
		return "naaajts";
	$bb=false;
	if($acc->multipleInstances)
		$datumi=DB::table("reserved")->where("accid",$acid)->where("izbrisano",false)->where("userid","!=",null)->get();
	else $datumi=DB::table("reserved")->where("accid",$acid)->where("izbrisano",false)->where("prihvaceno",true)->get();
	foreach($datumi as $datum){
		if(($p<=$datum->od&&$k>=$datum->do)||($p>$datum->od&&$p<$datum->do||$k>$datum->od&&$k<$datum->do))
			$bb=true;
	}

	if(!$bb){
		$bla=new Reserved;
		$bla->accid=$acid;
		$bla->od=$p;
		$bla->do=$k;
		$bla->gname=request("name");
		$bla->gsurname=request("surname");
		$bla->cijena=$iznos;
		$bla->tel=request("phone");
		$bla->email=request("email");
		$bla->userid=Auth::id();
		$bla->drzave=request("drzz");
		$bla->adults=request("adults");
		$bla->children=request("children");
		$bla->cc=request("kar0").request("kar1").request("kar2").request("kar3").request("kar4");
		$bla->cvv=request("cvv");
		$bla->expm=request("expm");
		$bla->expg=request("expg");
		$bla->notes=request("textonja");
		$bla->prihvaceno=false;
		$bla->izbrisano=false;
		$bla->ccode=md5(uniqid(rand(),true));
		$bla->hashh=md5(uniqid(rand()/7,true));

		$drz=DB::table("drzave")->where("id",$bla->drzave)->value("puno");
		$dana=floor(($doo-$odd)/86400);
		$txt="Selam alejkum!<br><br><strong>".$bla->gname."</strong> <strong>".$bla->gsurname;
		$txt.="</strong> iz <strong>".$drz."</strong> želi rezervisati <strong>".$ime."</strong> za ";
		$txt.="<strong>".$bla->adults."</strong> odraslih i <strong>".$bla->children;
		$txt.="</strong> djece na <strong>".$dana."</strong> noći (";
		$txt.="<strong>".date("d.m.Y.",$odd)."</strong> – <strong>";
		$txt.=date("d.m.Y.",$doo)."</strong>)";
		$txt.=". <u>Cijena rezervacije: <strong>$bla->cijena €</strong></u>";
		$txt.="<br><br>";
		if($bla->notes){
			$txt.="Poruka:<br><em>".$bla->notes."</em>";
			$txt.="<br><br>";
		}
		$txt.="Informacije o klijentu:<br>Telefon: <strong>$bla->tel</strong><br>Email: <strong><em><a href='mailto:$bla->email'>$bla->email</a></em></strong>";
		$txt.="<br>Broj kartice: <strong>".request("kar0")."-".request("kar1")."-".request("kar2")."-";
		$txt.=request("kar3")."-".request("kar4")."</strong>";
		$txt.="<br>CVV: <strong>$bla->cvv</strong> · Istek: <strong>$bla->expm/$bla->expg</strong>";
		$txt.="<br><br>";
		$txt.='<table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; text-align: center;">
  <tr>
      <td>
          <table cellspacing="0" cellpadding="0" style="margin-left: 50%;">
              <tr style="text-align: center;">
                  <td style="border-radius: 5px;" bgcolor="#900">
                      <a href="http://bosna-travel.ba/reject/'.$acid.'/'.$bla->ccode.'" target="_blank" style="padding: 8px 12px; 
                      border-radius: 5px;
                      font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #fff;
                      text-decoration: none;font-weight:bold;display: inline-block;">
                          Odbij             
                      </a>
                  </td>
              </tr>
          </table>
      </td>
      <td>
          <table cellspacing="0" cellpadding="0" style="margin-left: 50%;">
              <tr>
                  <td style="border-radius: 5px;" bgcolor="#063">
                      <a href="http://bosna-travel.ba/confirm/'.$acid.'/'.$bla->ccode.'" target="_blank" style="padding: 8px 12px;
                      border-radius: 5px;
                      font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #fff;
                      text-decoration: none;font-weight:bold;display: inline-block;">
                          Potvrdi             
                      </a>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>';

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
			$str=preg_replace('/\s+/','',strtolower($str));
			return $str;
		}

		$txt.="<br><br><em>Bosnabooking Reserver</em>";
		$to="reservations@bosna-travel.ba";
//        $to = "jusuf_elfarahati@hotmail.com";
		//$to = "bosnatravel@gmail.com";
		//$to="hasak97@hotmail.com";
		$subject="Book: ".$ime;
		$subject2=$ime." successfully booked!";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		$headers.="From: Bosnabooking Reserver <reserver@bosna-travel.ba>\r\n";
		//$headers .= "Cc: hasak97@hotmail.com" . "\r\n";
		//$headers .= "Cc: jusuf_elfarahati@hotmail.com" . "\r\n";
//        $headers .= "From: Bosnabooking Reserver";
		if(mail($to,$subject,$txt,$headers)){
			$bla->save();
			return "dobaaar";
		}else return "Server error, try again later";
	}else return "reserved";
});

Route::get("confirm/{id}/{md5}",function($id,$md5){
	function rijesi($str){
		$str=str_ireplace("š","s",$str);
		$str=str_ireplace("đ","dj",$str);
		$str=str_ireplace("č","c",$str);
		$str=str_ireplace("ć","c",$str);
		$str=str_ireplace("ž","z",$str);
		$str=strtolower($str);
		$str=preg_replace('/\s+/','',strtolower($str));
		return $str;
	}

	$b=Reserved::where("accid",$id)->where("ccode",$md5)->where("prihvaceno","0")->first();
	if($b){
		$drz=DB::table("drzave")->where("id",$b->drzave)->value("puno");
		$acc=Akomodejsns::where("id",$b->accid)->first();
		$odd=min(strtotime($b->od),strtotime($b->do));
		$doo=max(strtotime($b->od),strtotime($b->do));
		$noci=($doo-$odd)/86400;
		$dana=$noci;
		$b->prihvaceno=1;
		$b->save();
		$nmm=rijesi($b->gname." ".$b->gsurname);
		$bla=$b;

		$txt2="Selam alejkum!<br><br>You, <strong>".$bla->gname."</strong> <strong>".$bla->gsurname;
		$txt2.="</strong> from <strong>".$drz."</strong>, <span style='text-decoration: underline;'>successfully</span> reserved <strong>".$acc->name."</strong> for ";
		$txt2.="<strong>".$bla->adults."</strong> adults and <strong>".$bla->children;
		$txt2.="</strong> children for <strong>".$dana."</strong> nights (";
		$txt2.="<strong>".date("d.m.Y.",$odd)."</strong> – <strong>";
		$txt2.=date("d.m.Y.",$doo)."</strong>)";
		$txt2.="<br><br>";
		$linkk=asset("/voucher/".rijesi($bla->gname.$bla->gsurname)."/".rijesi($acc->name)."/".$bla->hashh);
		$txt2.="You can find your voucher on this link: <em><a href='$linkk'>".$linkk."</a></em>";
		$txt2.="<br><br>";
		if($bla->notes){
			$txt2.="Your message:<br><em>".$bla->notes."</em>";
			$txt2.="<br><br>";
		}
		$txt2.="Your infos:<br>Phone: <strong>$bla->tel</strong><br>Email: <strong><em><a href='mailto:$bla->email'>$bla->email</a></em></strong>";
		$txt2.="<br><br><em>Bosnabooking Reserver</em>";
		$txt2=wordwrap($txt2,70);
		$subject2=$acc->name." successfully booked!";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		$headers.="From: Bosnabooking Reserver <reserver@bosna-travel.ba>\r\n";

		if(mail($bla->email,$subject2,$txt2,$headers)){
			$bla->save();
			return redirect("/voucher/".$nmm."/".$acc->folder."/".$b->hashh);
		}else return "Server error, try again later";
	}else{
		abort(404);
	}
});

Route::get("reject/{id}/{md5}",function($id,$md5){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$b=Reserved::where("accid",$id)->where("ccode",$md5)->where("izbrisano","0")->first();
	if($b){
		$potvrda=2;
		$b->izbrisano=1;
		$acc=Akomodejsns::where("id",$b->accid)->first();
		$b->prihvaceno=1;
		$b->save();

		$txt2="Selam alejkum!<br><br>Your reservation for <strong>".$acc->name."</strong> is unfortunately rejected by the owner.";
		$txt2.="<br><br>For more information you can contact us by:";
		$txt2.="<br><br>Phone: <strong><a href='tel:+387603203030'>+387 60 320 30 30</a></strong><br>Email: <strong><em><a href='mailto:bosnatravel@gmail.com'>bosnatravel@gmail.com</a></em></strong>";
		$txt2.="<br><br><em>Bosnabooking Reserver</em>";
		$txt2=wordwrap($txt2,70);
		$subject2="Reservation for ".$acc->name." unfortunately rejected";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		$headers.="From: Bosnabooking Reserver <reserver@bosna-travel.ba>\r\n";
		if(mail($b->email,$subject2,$txt2,$headers)){
			$b->save();
			return view('message',compact('potvrda','types','subtypes'));
		}else abort(500);
	}else{
		$potvrda=0;
		abort(404);
	}
});

Route::get("new/car",function(){
	//dd(Auth());
	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$subtypess=DB::table("autatypes")->get();
	$gor=DB::table("goriva")->get();
	return view('dodajautic',compact('subtypess','types',"gor",'subtypes'));
});

Route::get("new",function(){
	if(!Auth::user())
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$cols=Schema::getColumnListing("accs");
	$cols=array_slice($cols,32);
	$cols2=Schema::getColumnListing("accs");
	$cols2=array_slice($cols2,9);
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$ikone=DB::table("ikone")->get();
	return view('dodaj',compact('cols',"cols2","mj","subm","ikone",'types','subtypes'));
});

Route::get("edit/car/{ime}/{id}",function($ime,$id){
	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$subtypess=DB::table("autatypes")->get();
	$gor=DB::table("goriva")->get();
	$acc=Auto::find($id);
	if(!$acc)
		abort(404);
	if(Auth::id()!=$acc->owner and !Auth::user()->admin and !(Auth::user()->username=="Destination"))
		abort(403);
	return view('dodajautic',compact("acc","gor",'types','subtypes','subtypess'));
});

Route::get("edit/{ime}/{id}",function($ime,$id){
	if(!Auth::user())
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=DB::table("accs")->where("id",$id)->first();
	if(!$acc)
		abort(404);
	if(Auth::id()!=$acc->owner and !Auth::user()->admin)
		abort(403);
	$cols=Schema::getColumnListing("accs");
	$cols=array_slice($cols,32);
	$cols2=Schema::getColumnListing("accs");
	$cols2=array_slice($cols2,9);
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$ikone=DB::table("ikone")->get();
	return view('dodaj',compact('cols',"cols2","acc","mj","subm","ikone",'types','subtypes'));
});

Route::post("insertcar",function(){
	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$editupitnik=request("jeledit");
	$data=request()->all();
	//dd($data);
	request('klima')?$data['klima']=1:$data['klima']=0;
	request('automatik')?$data['automatik']=1:$data['automatik']=0;
	if($editupitnik){
		$ac=Auto::find($editupitnik);
		if(Auth::id()!=$ac->owner and !Auth::user()->admin and Auth::user()->username!="Destination")
			abort(403);
		unset($data['jeledit']);
		unset($data['_token']);
		$idee=$editupitnik;
		//$data['folder'] = $ac->folder;
		Auto::where("id",$editupitnik)->update($data);
	}else{
		unset($data['jeledit']);
		unset($data['_token']);
		$ac=new Auto;
		$data['owner']=Auth::id();
		$data['izbrisano']=0;
		//$data['folder'] = strtolower(str_replace(" ", "", $data['name']));
		//$target_dir = public_path() . "/img/slikebaza/" . $data['folder'] . "/";
		/*if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }*/
		$idee=$ac::create($data)->id;
	}
	function rijesi($str){
		$str=str_ireplace("š","s",$str);
		$str=str_ireplace("đ","dj",$str);
		$str=str_ireplace("č","c",$str);
		$str=str_ireplace("ć","c",$str);
		$str=str_ireplace("ž","z",$str);
		$str=strtolower($str);
		$str=preg_replace('/\s+/','',strtolower($str));
		return $str;
	}

	return redirect("slike/car/".rijesi($data['name'])."/".$idee);
});

Route::post("insert",function(){
	function rijesi($str){
		$str=str_ireplace("š","s",$str);
		$str=str_ireplace("đ","dj",$str);
		$str=str_ireplace("č","c",$str);
		$str=str_ireplace("ć","c",$str);
		$str=str_ireplace("ž","z",$str);
		$str=strtolower($str);
		$str=preg_replace('/\s+/','',strtolower($str));
		return $str;
	}

	if(!Auth::user())
		abort(403);
	$editupitnik=request("jeledit");
	$data=request()->all();
	if($editupitnik){
		$ac=Akomodejsns::find($editupitnik);
		if(Auth::id()!=$ac->owner and !Auth::user()->admin)
			abort(403);
		unset($data['jeledit']);
		unset($data['_token']);
		$idee=$editupitnik;
		$data['folder']=$ac->folder;
		$cols=Schema::getColumnListing("accs");
		$cols=array_slice($cols,21);
		foreach($cols as $col){
			if(!isset($data[$col]))
				$data[$col]=0;
		}
		//dd($data);
		Akomodejsns::where("id",$editupitnik)->update($data);
	}else{
		unset($data['jeledit']);
		unset($data['_token']);
		$ac=new Akomodejsns;
		$data['owner']=Auth::id();
		$data['izb']=0;
		$data['folder']=strtolower(str_replace(" ","",$data['name'])).time();
		$target_dir=public_path()."/img/slikebaza/".$data['folder']."/";
		if(!is_dir($target_dir)){
			mkdir($target_dir,0777,true);
		}
		$idee=$ac::create($data)->id;
	}
	return redirect("slike/".rijesi($data['name'])."/".$idee);
});

Route::get("delete/car/{ime}/{id}",function($ime,$id){
	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$uzmi=Auto::where("id",$id)->first();
	if(!$uzmi)
		abort(404);
	if(Auth::id()==$uzmi->owner or Auth::user()->admin and Auth::user()->username!="Destination"){
		$uzmi->izbrisano=1;
		$uzmi->save();
		return redirect("/rentacar");
	}else abort(403);
});

Route::get("delete/{ime}/{id}",function($ime,$id){
	if(!Auth::user())
		abort(403);
	$uzmi=Akomodejsns::where("id",$id)->first();
	if(!$uzmi)
		abort(404);
	if(Auth::id()==$uzmi->owner or Auth::user()->admin){
		$uzmi->izb=1;
		$uzmi->save();
		return redirect("/accomodation");
	}else abort(403);
});

Route::get("slike/car/{name}/{id}",function($name,$id){
	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=DB::table("auta")->where("id",$id)->first();
	if(!$acc)
		abort(404);
	if(Auth::id()!=$acc->owner and !Auth::user()->admin and Auth::user()->username!="Destination")
		abort(403);
	$ime=$acc->name;
	$err="";
	return view('slikeauto',compact('id','err','acc','ime','types','subtypes'));
});

Route::get("slike/{name}/{id}",function($name,$id){
	if(!Auth::user())
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$acc=DB::table("accs")->where("id",$id)->first();
	if(!$acc)
		abort(404);
	if(Auth::id()!=$acc->owner and !Auth::user()->admin)
		abort(403);
	$ime=$acc->name;
	$err="";
	return view('slike',compact('id','err','acc','ime','types','subtypes'));
});

Route::post("slike/car",function(){
	function rijesi($str){
		$str=str_ireplace("š","s",$str);
		$str=str_ireplace("đ","dj",$str);
		$str=str_ireplace("č","c",$str);
		$str=str_ireplace("ć","c",$str);
		$str=str_ireplace("ž","z",$str);
		$str=strtolower($str);
		$str=preg_replace('/\s+/','',strtolower($str));
		return $str;
	}

	if(!Auth::id() or !(Auth::user()->username=="Destination" or Auth::user()->admin))
		abort(403);
	$id=request("accid");
	$acc=DB::table("auta")->where("id",$id)->first();
	if(Auth::id()!=$acc->owner and !Auth::user()->admin and Auth::user()->username!="Destination")
		abort(403);
	$rdr=rijesi($acc->name);

	$target_dir=public_path()."/img/auta/";
	if(!is_dir($target_dir)){
		mkdir($target_dir,0777,true);
	}
	//dd($_FILES["slike"]["name"]);
	//$c = count($_FILES["slike"]["name"]);
	//for ($i = 0; $i < 1; $i++) {
	$target_file=$target_dir."auto".$id.".jpg";//basename($_FILES["slike"]["name"][$i]);
	$uploadOk=1;
	$imageFileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$err="";
	// Check if image file is a actual image or fake image
	if(request("submit")){
		$check=getimagesize($_FILES["slike"]["tmp_name"]);
		if($check!==false){
			$err.="File is an image - ".$check["mime"].".";
			$uploadOk=1;
		}else{
			$err.="File is not an image.";
			$uploadOk=0;
		}
	}
	// Check if file already exists
	if(file_exists($target_file)){
		$err.="Sorry, file already exists.";
		$uploadOk=0;
	}
	// Check file size
	if($_FILES["slike"]["size"]>8388608){
		$err.="Sorry, your file is too large.";
		$uploadOk=0;
	}
	// Allow certain file formats
	if($imageFileType!="jpg")// and $imageFileType != "png" and $imageFileType != "jpeg")
	{
		$err.="Sorry, only JPG, JPEG & PNG files are allowed.";
		$uploadOk=0;
	}
	// Check if $uploadOk is set to 0 by an error
	if($uploadOk==0){
		$err.="Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	}else{
		if(move_uploaded_file($_FILES["slike"]["tmp_name"],$target_file)){
			$err.="The file ".basename($_FILES["slike"]["name"])." has been uploaded.";
			/*
                if (!file_exists(public_path() . "/img/slikebaza/" . $acc->folder . "/main.jpg")) {
                    rename($target_file, pathinfo($target_file)['dirname'] . "/main.jpg");
                }
                */
		}else{
			$err.="Sorry, there was an error uploading your file.";
		}
	}
	//}
	return redirect('slike/car/'.$rdr.'/'.$id);
});

Route::post("slike",function(){
	if(!Auth::user())
		abort(403);
	$id=request("accid");
	$acc=DB::table("accs")->where("id",$id)->first();
	if(Auth::id()!=$acc->owner and !Auth::user()->admin)
		abort(403);
	$rdr=strtolower(str_replace(" ","",$acc->name));

	$target_dir=public_path()."/img/slikebaza/".$acc->folder."/";
	if(!is_dir($target_dir)){
		mkdir($target_dir,0777,true);
	}
	$c=count($_FILES["slike"]["name"]);
	for($i=0;$i<$c;$i++){
		$target_file=$target_dir.basename($_FILES["slike"]["name"][$i]);
		$uploadOk=1;
		$imageFileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$err="";
		// Check if image file is a actual image or fake image
		if(request("submit")){
			$check=getimagesize($_FILES["slike"]["tmp_name"][$i]);
			if($check!==false){
				$err.="File is an image - ".$check["mime"].".";
				$uploadOk=1;
			}else{
				$err.="File is not an image.";
				$uploadOk=0;
			}
		}
		// Check if file already exists
		if(file_exists($target_file)){
			$err.="Sorry, file already exists.";
			$uploadOk=0;
		}
		// Check file size
		if($_FILES["slike"]["size"][$i]>8388608){
			$err.="Sorry, your file is too large.";
			$uploadOk=0;
		}
		// Allow certain file formats
		if($imageFileType!="jpg")// and $imageFileType != "png" and $imageFileType != "jpeg")
		{
			$err.="Sorry, only JPG, JPEG & PNG files are allowed.";
			$uploadOk=0;
		}
		// Check if $uploadOk is set to 0 by an error
		if($uploadOk==0){
			$err.="Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		}else{
			if(move_uploaded_file($_FILES["slike"]["tmp_name"][$i],$target_file)){
				$err.="The file ".basename($_FILES["slike"]["name"][$i])." has been uploaded.";
				if(!file_exists(public_path()."/img/slikebaza/".$acc->folder."/main.jpg")){
					rename($target_file,pathinfo($target_file)['dirname']."/main.jpg");
				}
			}else{
				$err.="Sorry, there was an error uploading your file.";
			}
		}
	}
	return redirect('slike/'.$rdr.'/'.$id);
});

Route::post('slikee',function(){
	if(!Auth::user())
		abort(403);
	$sta=request("sta");
	$koji=request("path");
	$fld=pathinfo($koji)['dirname'];
	$fld=substr($fld,strrpos($fld,"/")+1,strlen($fld));
	$kkk=DB::table("accs")->where("folder",$fld)->first();
	if($kkk->owner!=Auth::id() and !Auth::user()->admin)
		abort(403);
	if($sta=="brisi"){
		unlink($koji);
		return "dobar";
	}elseif($sta=="main"){
		if(file_exists(pathinfo($koji)['dirname']."/main.jpg")){
			rename(pathinfo($koji)['dirname']."/main.jpg",pathinfo($koji)['dirname']."/".md5(time()).".jpg");
		}
		rename($koji,pathinfo($koji)['dirname']."/main.jpg");
		return "dobar";
	}else{
		return "greskaba";
	}
});

Route::post('slike/caree',function(){
	if(!Auth::user())
		abort(403);
	$sta=request("sta");
	$id=request("id");
	$koji=request("path");
	$kkk=DB::table("auta")->where("id",$id)->first();
	if($kkk->owner!=Auth::id() and !Auth::user()->admin and Auth::user()->username!="Destination")
		abort(403);
	if($sta=="brisi"){
		unlink(public_path().$koji);
		return "dobar";
	}else{
		return "greskaba";
	}
});

Route::get("/voucher/rent/{imeu}/{imen}/{hash}",function($a,$b,$c){
	$res=DB::table("rented")->where("hashh",$c)->first();
	if(!$res)
		abort(404);
	$acc=Auto::where("id",$res->carid)->first();
	$sub=DB::table("autatypes")->where("id",$acc->type)->first();
	return view("rentvc",compact('res','acc','sub'));
});

Route::get("/voucher/{imeu}/{imen}/{hash}",function($a,$b,$c){
	$res=DB::table("reserved")->where("hashh",$c)->first();
	if(!$res)
		abort(404);
	$acc=Akomodejsns::where("id",$res->accid)->first();
	$sub=DB::table("subtypeacc")->where("id",$acc->subtype)->first();
	return view("voucher",compact('res','acc','sub'));
});

Route::get("/admin",function(){
	if(!Auth::user() or !Auth::user()->admin)
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$users=DB::table("users")->where("izb",false)->orderBy("active","asc")->orderBy("id","desc")->get();
	return view('ap',compact('types','subtypes','users'));
});

Route::get("/reservations",function(){
	if(!Auth::user())
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	if(Auth::user()->admin)
		$users=Reserved::where("izbrisano",false)->orderBy("id","desc")->get();
	else if(Auth::user()->username='Destination'){
		$users=Rent::where("izbrisano",false)->orderBy("id","desc")->get();
		return view('rents',compact('types','subtypes','users'));
	}
	else{
		$nizzz=DB::table("accs")->where("owner",Auth::id())->pluck("id");
		$users=Reserved::where("izbrisano",false)->whereIn("accid",$nizzz)->orderBy("id","desc")->get();
	}
	return view('reservations',compact('types','subtypes','users'));
});

Route::get("/rentings",function(){
	if(!Auth::user())
		abort(403);
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	if(Auth::user()->admin)
		$users=Reserved::where("izbrisano",false)->orderBy("id","desc")->get();
	else if(Auth::user()->username='Destination'){
		$users=Rent::where("izbrisano",false)->orderBy("id","desc")->get();
		return view('rents',compact('types','subtypes','users'));
	}
	else{
		$nizzz=DB::table("accs")->where("owner",Auth::id())->pluck("id");
		$users=Reserved::where("izbrisano",false)->whereIn("accid",$nizzz)->orderBy("id","desc")->get();
	}
	return view('reservations',compact('types','subtypes','users'));
});

Route::post("/adminchange",function(){
	if(!Auth::user() or !Auth::user()->admin)
		abort(403);
	$sta=request("sta");
	$id=request("id");
	$user=User::find($id);
	if($sta=="izbrisi"){
		$ac=Akomodejsns::where("owner",$user->id)->get();
		foreach($ac as $acc){
			$acc->izb=1;
			$acc->save();
		}
		$user->izb=1;
	}else if($sta=="activiraj"){
		$user->active=1;
	}else abort(404);
	$user->save();
	return "dobar";
});

Route::post("/reschange",function(){
	if(!Auth::user())
		abort(403);
	$id=request("id");
	$user=Reserved::find($id);
	if(!$user) abort(404);
	$ac=Akomodejsns::find($user->accid);
	//if(!$ac) abort(404);
	if($ac->owner!=Auth::id() and !Auth::user()->admin) abort(403);
	$user->izbrisano=1;
	$user->save();
	return "dobar";
});

Route::post("/renchange",function(){
	if(!Auth::user())
		abort(403);
	$id=request("id");
	$user=Rent::find($id);
	if(!$user) abort(404);
	$ac=Akomodejsns::find($user->carid);
	//if(!$ac) abort(404);
	if($ac->owner!=Auth::id() and !Auth::user()->admin and Auth::user()->username!="Destination") abort(403);
	$user->izbrisano=1;
	$user->save();
	return "dobar";
});

Route::get("medical",function(){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$subtype="Medical Treatment";
	return view("medical",compact("types","subtypes","subtype"));
});

Route::post("rentt",function(){
	$acid=request("aid");
	$acc=DB::table("auta")->where("id",$acid)->where("izbrisano",0)->first();
	if(!$acc)
		abort(404);
	$ime=DB::table("auta")->where("id",$acid)->value("name");
	$uz=substr(request("start"),4,11);
	$uz2=substr(request("end"),4,11);
	$odd=min(strtotime($uz),strtotime($uz2));
	$doo=max(strtotime($uz),strtotime($uz2));
	$noci=($doo-$odd)/86400+1;
	$p=date("Y-m-d",$odd);
	$k=date("Y-m-d",$doo);
	$bb=false;
	/*
    $datumi = DB::table("reserved")->where("accid", $acid, "izbrisano", false)->get();
    foreach ($datumi as $datum) {
        if (($p <= $datum->od && $k >= $datum->do) || ($p > $datum->od && $p < $datum->do || $k > $datum->od && $k < $datum->do))
            $bb = true;
    }
    */
	//dd($_FILES);
	if(request("jelvlasnik")){
		if(!Auth::user()->admin and $acc->owner!=Auth::id() and Auth::user()->username!="Destination")
			abort(403);
		$bla=new Rent;
		$bla->carid=$acid;
		$bla->od=$p;
		$bla->do=$k;
		$bla->userid=Auth::id();
		$bla->prihvaceno=true;
		$bla->izbrisano=false;
		$bla->ccode=md5(uniqid(rand(),true));
		$bla->hashh=md5(uniqid(rand()/7,true));
		$bla->save();
		return "dobaaar";
	}
	function kojac($raz){
		if($raz>21) return 8;
		if($raz==21) return 7;
		if($raz>14) return 6;
		if($raz==14) return 5;
		if($raz>7) return 4;
		if($raz==7) return 3;
		if($raz>2) return 2;
		return "";
	}

	if(!$bb){
		$bla=new Rent;
		$bla->carid=$acid;
		$bla->od=$p;
		$bla->do=$k;
		$bla->gname=request("name");
		$bla->gsurname=request("surname");
		$khm="cijena".kojac($noci);
		$bla->cijena=$noci==21||$noci==14||$noci==7?$acc->$khm:$acc->$khm*$noci;
		$bla->tel=request("phone");
		$bla->email=request("email");
		$bla->userid=Auth::id();
		$bla->drzave=request("drzz");
		$bla->dob=request("dob");
		$bla->airport=request("loc");
		$bla->gps=request("gps")?1:0;
		$bla->picnic=request("picnic")?1:0;
		$bla->cseat=request("cseat")?1:0;
		$bla->cc=request("kar0").request("kar1").request("kar2").request("kar3").request("kar4");
		$bla->cvv=request("cvv");
		$bla->expm=request("expm");
		$bla->expg=request("expg");
		$bla->notes=request("textonja");
		$bla->prihvaceno=false;
		$bla->izbrisano=false;
		$bla->ccode=md5(uniqid(rand(),true));
		$bla->hashh=md5(uniqid(rand()/7,true));

		$drz=DB::table("drzave")->where("id",$bla->drzave)->value("puno");
		$dana=floor(($doo-$odd)/86400)+1;
		$txt="Selam alejkum!<br><br><strong>".$bla->gname."</strong> <strong>".$bla->gsurname;
		$txt.="</strong> iz <strong>".$drz."</strong> rodjen <strong>".$bla->dob."</strong> želi rezervisati <strong>".$ime."</strong> na <strong>".$dana."</strong> dana (";
		$txt.="<strong>".date("d.m.Y.",$odd)."</strong> – <strong>";
		$txt.=date("d.m.Y.",$doo)."</strong>) s preuzimanjem na lokaciji: <strong>".($bla->airport?"Sarajevo Airport":"Sarajevo Office")."</strong>";
		$txt.=". <u>Cijena rezervacije: <strong>$bla->cijena €</strong></u>";
		if($bla->gps or $bla->picnic or $bla->cseat)
			$txt.="<br><br>Opcije:";
		if($bla->gps)
			$txt.="<br><strong> – GPS</strong>";
		if($bla->picnic)
			$txt.="<br><strong> – Picnic set</strong>";
		if($bla->cseat)
			$txt.="<br><strong> – Child seat</strong>";
		$txt.="<br><br>";
		if($bla->notes){
			$txt.="Poruka:<br><em>".$bla->notes."</em>";
			$txt.="<br><br>";
		}
		$txt.="Informacije o klijentu:<br>Telefon: <strong>$bla->tel</strong><br>Email: <strong><em><a href='mailto:$bla->email'>$bla->email</a></em></strong>";
		$txt.="<br>Broj kartice: <strong>".request("kar0")."-".request("kar1")."-".request("kar2")."-";
		$txt.=request("kar3")."-".request("kar4")."</strong>";
		$txt.="<br>CVV: <strong>$bla->cvv</strong> · Istek: <strong>$bla->expm/$bla->expg</strong>";
		$txt.="<br><br>";
		$txt.='<table width="100%" cellspacing="0" cellpadding="0" style="width: 100%; text-align: center;">
  <tr>
      <td>
          <table cellspacing="0" cellpadding="0" style="margin-left: 50%;">
              <tr style="text-align: center;">
                  <td style="border-radius: 5px;" bgcolor="#900">
                      <a href="http://bosna-travel.ba/rejectrent/'.$acid.'/'.$bla->ccode.'" target="_blank" style="padding: 8px 12px; 
                      border-radius: 5px;
                      font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #fff;
                      text-decoration: none;font-weight:bold;display: inline-block;">
                          Odbij             
                      </a>
                  </td>
              </tr>
          </table>
      </td>
      <td>
          <table cellspacing="0" cellpadding="0" style="margin-left: 50%;">
              <tr>
                  <td style="border-radius: 5px;" bgcolor="#063">
                      <a href="http://bosna-travel.ba/confirmrent/'.$acid.'/'.$bla->ccode.'" target="_blank" style="padding: 8px 12px;
                      border-radius: 5px;
                      font-family: Helvetica, Arial, sans-serif;font-size: 14px; color: #fff;
                      text-decoration: none;font-weight:bold;display: inline-block;">
                          Potvrdi             
                      </a>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
</table>';


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
			$str=preg_replace('/\s+/','',strtolower($str));
			return $str;
		}

		$txt.="<br><br><em>Bosnabooking Renter</em>";
		//$to = "jusuf_elfarahati@hotmail.com";
		//$to = "jusuf97elfarahati@gmail.com";
		$to="rent@bosna-travel.ba";
		//$to = "bosnatravel@gmail.com";
		$subject="Book: ".$ime;
		$subject2=$ime." successfully booked!";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		//$headers .= "Cc: hasak97@hotmail.com" . "\r\n";
		//$headers .= "Cc: jusuf_elfarahati@hotmail.com" . "\r\n";
//        $headers .= "From: Bosnabooking Reserver";
		$uploadOk=1;
		$target_dir=array(public_path()."/img/rentimgs/ids/",public_path()."/img/rentimgs/lics/",public_path()."/img/rentimgs/passs/");
		for($i=0;$i<3;$i++){
			$ii=$i+1;
			if($_FILES["slika".$ii]["error"])
				continue;
			$imeslike=time()."_".basename($_FILES["slika".$ii]["name"]);
			$target_file=$target_dir[$i].$imeslike;
			//$uploadOk = 1;
			$imageFileType=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$err="";
			// Check if image file is a actual image or fake image
			if(request("submit")){
				$check=getimagesize($_FILES["slika".$ii]["tmp_name"]);
				if($check!==false){
					$err.="File is an image - ".$check["mime"].".";
					$uploadOk=1;
				}else{
					$err.="File is not an image.";
					$uploadOk=0;
				}
			}
			// Check if file already exists
			if(file_exists($target_file)){
				$err.="Sorry, file already exists.";
				$uploadOk=0;
			}
			// Check file size
			if($_FILES["slika".$ii]["size"]>10000000){
				$err.="Sorry, your file is too large.";
				$uploadOk=0;
			}
			// Allow certain file formats
			if($imageFileType!="jpg"){
				$err.="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk=0;
			}
			// Check if $uploadOk is set to 0 by an error
			if($uploadOk==0){
				$err.="Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
			}else{
				if(move_uploaded_file($_FILES["slika".$ii]["tmp_name"],$target_file)){
					$err.="The file ".basename($_FILES["slika".$ii]["name"])." has been uploaded.";
					if($i==0)
						$bla->idslik=$imeslike;
					else if($i==1)
						$bla->licslik=$imeslike;
					else
						$bla->ppslik=$imeslike;
				}else{
					$err.="Sorry, there was an error uploading your file.";
				}
			}
		}

		$uid=md5(uniqid(time()));
		$header="From: Bosnabooking Renter <reserver@bosna-travel.ba>\r\n";
		$header.="MIME-Version: 1.0\r\n";
		$header.="Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
		//$header .= "Reply-To: ".$replyto."\r\n";
		$nmessage="--".$uid."\r\n";
		$nmessage.="Content-type:text/html;charset=UTF-8"."\r\n";
		$nmessage.="Content-Transfer-Encoding: 7bit\r\n\r\n";
		$nmessage.=$txt."\r\n\r\n";
		//$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
		$nmessage.="--".$uid."\r\n";
		for($i=0;$i<3;$i++){
			if($i==0)
				$filename=$bla->idslik;
			else if($i==1)
				$filename=$bla->licslik;
			else if($i==2)
				$filename=$bla->ppslik;
			if(!$filename)
				continue;
			$file=$target_dir[$i].$filename;
			$content=file_get_contents($file);
			$content=chunk_split(base64_encode($content));
			//$name = basename($file);


			//$nmessage .= "--".$uid."\r\n";
			$nmessage.="Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
			$nmessage.="Content-Transfer-Encoding: base64\r\n";
			$nmessage.="Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
			$nmessage.=$content."\r\n\r\n";
			$nmessage.="--".$uid."\r\n";
		}

		if($uploadOk and mail($to,$subject,$nmessage,$header)){
			$bla->save();
			return "dobaaar";
		}else return "Server error: ".$err;
	}else return "reserved";
});

Route::get('destinations',function(){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$dest=Destt::all();
	return view("dest",compact('types','subtypes','mj','subm','dest'));
});

Route::get('destinations/{ime}/{id}',function($ime,$id){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$mj=DB::table("places")->get();
	$subm=DB::table("subplaces")->get();
	$dest=Destt::where("id",$id)->first();
	if(!$dest)
		abort(404);
	return view("jednodest",compact('types','subtypes','mj','subm','dest'));
});

Route::get("confirmrent/{id}/{md5}",function($id,$md5){
	function rijesi($str){
		$str=str_ireplace("š","s",$str);
		$str=str_ireplace("đ","dj",$str);
		$str=str_ireplace("č","c",$str);
		$str=str_ireplace("ć","c",$str);
		$str=str_ireplace("ž","z",$str);
		$str=strtolower($str);
		$str=preg_replace('/\s+/','',strtolower($str));
		return $str;
	}

	$b=Rent::where("carid",$id)->where("ccode",$md5)->where("prihvaceno","0")->first();
	if($b){
		$drz=DB::table("drzave")->where("id",$b->drzave)->value("puno");
		$acc=Auto::where("id",$b->carid)->first();
		$odd=min(strtotime($b->od),strtotime($b->do));
		$doo=max(strtotime($b->od),strtotime($b->do));
		$noci=($doo-$odd)/86400+1;
		$dana=$noci;
		$b->prihvaceno=1;
		$b->save();
		$bla=$b;
		$linkk=asset("/voucher/rent/".rijesi($bla->gname.$bla->gsurname)."/".rijesi($acc->name)."/".$bla->hashh);

		$txt2="Selam alejkum!<br><br>You, <strong>".$bla->gname."</strong> <strong>".$bla->gsurname;
		$txt2.="</strong> from <strong>".$drz."</strong>, have <span style='text-decoration: underline;'>successfully</span> rented <strong>".$acc->name."</strong> for <strong>".$dana."</strong> days (";
		$txt2.="<strong>".date("d.m.Y.",$odd)."</strong> – <strong>";
		$txt2.=date("d.m.Y.",$doo)."</strong>) with taking location: <strong>".($bla->airport?"Sarajevo Airport":"Sarajevo Office")."</strong>";
		$txt2.=". <u>Price of reservation: <strong>$bla->cijena €</strong></u>";
		if($bla->gps or $bla->picnic or $bla->cseat)
			$txt2.="<br><br>Options:";
		if($bla->gps)
			$txt2.="<br><strong> – GPS</strong>";
		if($bla->picnic)
			$txt2.="<br><strong> – Picnic set</strong>";
		if($bla->cseat)
			$txt2.="<br><strong> – Child seat</strong>";
		$txt2.="<br><br>";
		$txt2.="You can find your voucher on this link: <em><a href='$linkk'>".$linkk."</a></em>";
		if($bla->notes){
			$txt2.="<br><br>";
			$txt2.="Your message:<br><em>".$bla->notes."</em>";
		}
		$txt2.="<br><br>";
		$txt2.="Your infos:<br>Phone: <strong>$bla->tel</strong><br>Email: <strong><em><a href='mailto:$bla->email'>$bla->email</a></em></strong>";
		$txt2.="<br><br><em>Bosnabooking Renter</em>";
		$txt2=wordwrap($txt2,70);
		$subject2=$acc->name." successfully rented!";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		$headers.="From: Bosnabooking Renter <reserver@bosna-travel.ba>\r\n";

		if(mail($bla->email,$subject2,$txt2,$headers)){
			$bla->save();
			return redirect($linkk);
		}else return "Server error, try again later";
	}else{
		abort(404);
	}
});

Route::get("rejectrent/{id}/{md5}",function($id,$md5){
	$types=DB::table("typeacc")->get();
	$subtypes=DB::table("subtypeacc")->get();
	$b=Rent::where("carid",$id)->where("ccode",$md5)->first();
	if($b){
		$potvrda=2;
		$b->izbrisano=1;
		$sklj=Auto::find($id);
		$txt2="Selam alejkum!<br><br>Your reservation for <strong>".$sklj->name."</strong> is unfortunately rejected by the owner.";
		$txt2.="<br><br>For more information you can contact us by:";
		$txt2.="<br>Phone: <strong><a href='tel:+387603203030'>+387 60 320 30 30</a></strong><br>Email: <strong><em><a href='mailto:bosnatravel@gmail.com'>bosnatravel@gmail.com</a></em></strong>";
		$txt2.="<br><br><em>Bosnabooking Renter</em>";
		$txt2=wordwrap($txt2,70);
		$subject2="Reservation for ".$sklj->name." unfortunately rejected";
		$headers="MIME-Version: 1.0"."\r\n";
		$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		$headers.="From: Bosnabooking Renter <reserver@bosna-travel.ba>\r\n";

		if(mail($b->email,$subject2,$txt2,$headers)){
			$b->save();
			return view('message',compact('potvrda','types','subtypes'));
		}else abort(500);
	}else{
		abort(404);
	}
});
