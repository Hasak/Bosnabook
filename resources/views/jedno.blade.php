<?php
/**
 * Created by PhpStorm.
 * User: jusuf
 * Date: 19/01/2019
 * Time: 11:58
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
	<link rel="stylesheet" href="{{asset("/css/main.css")}}">
@endsection

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
@section("title") {{$subtype}} · Bosnabooking @endsection
@section("content")
	<section class="property-area section-gap relative" id="property">
		<div class="overlay overlay-bg"></div>
		<div class="container ccc">
			<div class="row">
				<div class="col header-text" style="margin-top: 25px;">
					<h1>{{--<span class="fa-fw {{$ikon}}"></span> --}}{{$subtype}}</h1>
				</div>
			</div>
			<div class="row bijelo mb-2 c">
				<div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Owner"><span
								class="fas fa-user fa-fw"></span> {{$acc->useriuseri->username}}</span></div>
				<div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Type"><span
								class="{{$acc->sabtajp->icon}} fa-fw"></span> {{substr($acc->sabtajp->ime,0,strlen($acc->sabtajp->ime))}}</span>
				</div>
				<div class="col-lg-4 mb-3"><span class="pilula" data-toggle="tooltip" title="Location"><span
								class="fas fa-map-marker-alt fa-fw"></span> {{$acc->plejs->name}}
                        · {{$acc->plejs->plejsp->name}}</span></div>
			</div>
			<div class="row mt-5rem">
				<div class="col-lg-4">
					<a class="box-1"
					   href="{{file_exists(public_path()."/img/slikebaza/".$acc->folder."/main.jpg")?asset("img/slikebaza/".$acc->folder."/main.jpg"):asset("img/no-image.png")}}"
					   data-toggle="lightbox" data-gallery="example-gallery">
						<img id="maglavnaba"
							 src="{{file_exists(public_path()."/img/slikebaza/".$acc->folder."/main.jpg")?asset("img/slikebaza/".$acc->folder."/main.jpg"):asset("img/no-image.png")}}"
							 alt="Main Photo"
							 class="img-thumbnail zb mb-2 bn">
					</a>
					<table class="acctabela zuta table-sm table-responsive-lg">
						@php $ii=0; $y="<span class='gr'>Yes</span>"; $n="<span class='rd'>No</span>" @endphp
						@foreach($cols as $cool)
							@if($acc->$cool!=0 and $acc->$cool!=null or $ii>=23)
								<tr>
									<td class="ljv">
										@php
											$fic=$cool;
											for ($i=1;$i<strlen($fic);$i++){
												if($fic[$i]=="/"){
													$fic[$i+1]=strtoupper($fic[$i+1]);
												}
												else if($fic[$i-1]!="/" and $fic[$i]==strtoupper($fic[$i])){
													for($j=strlen($fic)-1;$j>$i;$j--){
														$fic[$j+1]=$fic[$j];
													}
													//$fic[$j+1]=strtolower($fic[$j+1]);
													if($ii<3 or $ii>14)
														$fic[$i+1]=strtolower($fic[$i]);
													else {
														$fic[$i+1]=$fic[$i];
														$fic[$i]=" ";
														break;
													}
													$fic[$i]=" ";
													//echo $fic."<br>";
													//$fic[$j]=' ';
												}
											}
											$fic[0]=strtoupper($fic[0]);
											if($fic[strlen($fic)-1]=="c" and $fic[strlen($fic)-2]=="W")
												$fic[strlen($fic)-1]="C";
										@endphp
										<span class="{{$ikone[$ii]->ikona}} fa-fw ikonicee"></span> {{$fic}}:
									</td>
									<td class="dsn">{!!$ii<23?"<span class='masveba'>".$acc->$cool."</span>":($acc->$cool?$y:$n)!!} {!!$tajpovi[$ii]=="float"?($ii==15?"%":"<span class='euroneuro'>€</span>"):($ii==2?"m<sup>2</sup>":"")!!}</td>
								</tr>
							@endif
							@php $ii++; @endphp
						@endforeach
					</table>
				</div>
				<input type="hidden" id="pocdatakima" value="{{isset($dp)&&isset($dk)?strtotime($dp):""}}">
				<input type="hidden" id="kradatakima" value="{{isset($dp)&&isset($dk)?strtotime($dk):""}}">
				<div class="col-lg-8">
					<div class="row c vc mb-5 text-center">
						<div class="col-lg-4 offset-lg-3">
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
									<th class="bnbnbn str {{(isset($dp)&&isset($dk)&&(date("m",strtotime($dp))!=$m||date("Y",strtotime($dp))!=$go))?"ptr":""}}" data-gd="li">
										{!!(isset($dp)&&isset($dk)&&(date("m",strtotime($dp))!=$m||date("Y",strtotime($dp))!=$go))?"<span class='fas fa-chevron-left'></span>":""!!}
									</th>
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
													class="fa-fw far fa-calendar-alt"></span> {{isset($dp)&&isset($dk)?date("F, Y",strtotime($dp)):date("F, Y",strtotime($go."-".$m."-".$d))}}</span>
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
										if(isset($dp) and isset($dk)){
											date("m",strtotime($dp))==$m&&date("Y",strtotime($dp))==$go?$s='a':$s='s';
										}
										else{
											$k?$s='s':$s='a';
										}
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
												if($acc->multipleInstances){
													foreach ($resad as $r){
														$udat=date("Y-m-d",strtotime($go."-".$m."-".$inc));
														if($udat>=$r->od and $udat<=$r->do){
															//$zauz=$r->prihvaceno?'z':'za';
															$zauz='z';
															break;
														}
													}
												}
												else{
													foreach ($res as $r){
														$udat=date("Y-m-d",strtotime($go."-".$m."-".$inc));
														if($udat>=$r->od and $udat<=$r->do){
															$zauz=$r->prihvaceno?'z':'za';
															break;
														}
													}
												}
												if(date("Y-m-d",strtotime($go."-".$m."-".$inc))>=date("Y-m-d",strtotime($dp)) and date("Y-m-d",strtotime($go."-".$m."-".$inc))<=date("Y-m-d",strtotime($dk)))
												$zauz.=" up";
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
									data-target="#nasbamodal"><span
										class="fa-fw fas fa-calendar-check-o"></span> {{Auth::id() && (Auth::user()->admin||$acc->owner==Auth::id())?"Close dates":"Book"}}
							</button>
						</div>
						<div class="col-lg-4 offset-lg-1">
							@if($mozel)
								<button class="btn bgzuta hvzelena btn-block"
										onclick="window.location.href='{{asset('/edit/'.rijesi($subtype).'/'.$acc->id)}}'">
									<span class="fas fa-fw fa-edit"></span> Edit
								</button>
								<button class="btn bgzuta hvzelena btn-block" data-toggle="modal" data-target="#confrrrmmodal">
									<span class="fas fa-fw fa-trash"></span> Delete
								</button>
							@endif
						</div>
					</div>
					<div class="row c vc">
						@php $i=1; @endphp
						@foreach(glob("img/slikebaza/".$acc->folder."/*.jpg") as $slik)
							{{--@if(substr($slik,strlen($slik)-8,4)!=="main")--}}
							<div class="col-3 mb-3 damoguuzetzadnjeg">
								<a class="box-1" href="{{asset($slik)}}"
								   data-toggle="lightbox" data-gallery="example-gallery">
									<div class="nasaklasa">
										<img class="img-fluid imgg damoguuzetzadnjeg2" src="{{asset($slik)}}">
									</div>
								</a>
							</div>
							{!!$i++%4==0?"</div><div class='row c vc'>":""!!}
							{{--@endif--}}
						@endforeach
					</div>
					<div class="row">
						<div class="col">

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="nasbamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
			 aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<form action="{{asset("/book")}}" method="post" id="bokform" class="w-100">
					<div class="modal-content w-100">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalCenterTitle"><span
										class="fa-fw fas fa-calendar-check"></span>{{!Auth::id()||$acc->owner!=Auth::id()?"Book: ".$subtype:"Close dates for ".$subtype}}
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body plava">
							<div id="alerrt" class="alert fade show s" role="alert">
								<span id="uturi"></span>
							</div>
							{{csrf_field()}}
							<input type="hidden" name="acid" value="{{$acc->id}}">
							<input type="hidden" name="jelvlasnik" value="{{Auth::id()&&$acc->owner==Auth::id()}}"
								   id="jelvl">
							<input type="hidden" name="acj1" id="acj1" value="{{$acc->priceJanuary}}">
							<input type="hidden" name="acj2" id="acj2" value="{{$acc->priceFebruary}}">
							<input type="hidden" name="acj3" id="acj3" value="{{$acc->priceMarch}}">
							<input type="hidden" name="acj4" id="acj4" value="{{$acc->priceApril}}">
							<input type="hidden" name="acj5" id="acj5" value="{{$acc->priceMay}}">
							<input type="hidden" name="acj6" id="acj6" value="{{$acc->priceJune}}">
							<input type="hidden" name="acj7" id="acj7" value="{{$acc->priceJuly}}">
							<input type="hidden" name="acj8" id="acj8" value="{{$acc->priceAugust}}">
							<input type="hidden" name="acj9" id="acj9" value="{{$acc->priceSeptember}}">
							<input type="hidden" name="acj10" id="acj10" value="{{$acc->priceOctober}}">
							<input type="hidden" name="acj11" id="acj11" value="{{$acc->priceNovember}}">
							<input type="hidden" name="acj12" id="acj12" value="{{$acc->priceDecember}}">
							@if(!Auth::id() or !Auth::user()->admin and $acc->owner!=Auth::id())
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
										<label for="adults"><span class="fa-fw fas fa-user-friends"></span> No of
											adults:</label>
										<select name="adults" id="adults" class="form-control ptr" required>
											<option value="0" disabled selected hidden>0</option>
											@for($i=1;$i<101;$i++)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>
									</div>
									<div class="col">
										<label for="children"><span class="fa-fw fas fa-baby"></span> No of
											children:</label>
										<select name="children" id="children" class="form-control ptr">
											<option value="0" selected>0</option>
											@for($i=1;$i<101;$i++)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>
									</div>
								</div>
							@endif
							<div class="form-row mb-3">
								<div class="col">
									<div class="input-daterange">
										<label for="dateee"><span class="fa-fw far fa-calendar-alt"></span> Check in
											&amp; Check out Date:</label>
										<span id="minimaxinoci" class="bold pull-right"></span>
										<input data-date-start-date="0d" id="dateee" type="text"
											   class="form-control ptr"
											   value="Check In &amp; Check Out" autocomplete="off" required>
									</div>
								</div>
							</div>
							@if(!Auth::id() or !Auth::user()->admin and $acc->owner!=Auth::id())
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
										class="fa-fw fas fa-calendar-check-o"></span> {{(!Auth::id() or $acc->owner!=Auth::id() and !Auth::user()->admin)?"Book":"Close dates"}}
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="modal fade" id="confrrrmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
			 aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content w-100">
						<div class="modal-header">
							<h5 class="modal-title text-danger" id="exampleModalCenterTitle"><span
										class="fa-fw fas fa-trash"></span>Delete {{$subtype}}
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Are you sure to delete this accommodation?</p>
							<p class="text-danger">This can not be undone</p>
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="ptr mdbtn btn bgsiva cb hvplava"><span
										class="fas fa-fw fa-undo"></span> Cancel
							</button>
							<button class="ptr mdbtn btn cb btn-danger" onclick="window.location.href='{{asset('/delete/'.rijesi($subtype).'/'.$acc->id)}}'"><span
										class="fa-fw fas fa-trash"></span> Delete
							</button>
						</div>
					</div>
			</div>
		</div>
	</section>
@endsection
