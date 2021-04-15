@extends('layouts.app')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
	<main>
		<table class="gm">
			<thead>
				<tr>
					<th colspan="10" style="font-size: 0.8em;">przytrzymując lewy przycisk myszy przesuń figurę nad pole docelowe i puść</th>
				</tr>
				<tr>
					<th>&nbsp;</th>
		@if($gracz==1)<!-- ============================== gracz 1 =============================== -->
					@for($linia=1;$linia<=8;$linia++)
						<th>{{$litery[$linia]}}</th>
					@endfor
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
					@for($linia=1;$linia<=8;$linia++)
						<tr>
							<th>{{$linia}}</th>
							@for($kolumna=1;$kolumna<=8;$kolumna++)
								<td class="pole @if(($kolumna+$linia)%2==1) b @endif" id="pole-{{$linia}}-{{$kolumna}}">
									@php echo $klasa->pokazFigure($linia,$kolumna) @endphp
								</td>
							@endfor
							<th>{{$linia}}</th>
						</tr>
					@endfor
			</tbody>
			<tfoot>
				<tr>
					<th>&nbsp;</th>
					@for($linia=1;$linia<=8;$linia++)
						<th>{{$litery[$linia]}}</th>
					@endfor
					<th>&nbsp;</th>
				</tr>
		@else<!-- ============================== gracz 2 =============================== -->
			@php $linia = 8; @endphp
					@while($linia>=1)
						<th>{{$litery[$linia]}}</th>
						@php $linia--; @endphp
					@endwhile
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@php $linia = 8; @endphp
				@while($linia>=1)
					<tr>
						<th>{{$linia}}</th>
						@while($kolumna>=1)
							<td class="pole @if(($kolumna+$linia)%2==1) b @endif" id="pole-{{$linia}}-{{$kolumna}}">
								@php echo $klasa->pokazFigure($linia,$kolumna) @endphp
							</td>
							@php $kolumna--; @endphp
						@endwhile
						<th>{{$linia}}</th>
					</tr>
					@php $linia--; @endphp
					@php $kolumna = 8; @endphp
				@endwhile
			</tbody>
			<tfoot>
				<tr>
					<th>&nbsp;</th>
					@php $linia = 8; @endphp
					@while($linia>=1)
						<th>{{$litery[$linia]}}</th>
						@php $linia--; @endphp
					@endwhile
					<th>&nbsp;</th>
				</tr>
		@endif<!-- ============================== wszyscy =============================== -->
			</tfoot>
		</table>
		<section class="game">
			<h2>Szachy Online</h2>
			<table class="min">
				<tr>
					<td><img src="{{$folder}}/images/35.png" alt="białe"></td>
					<td>{{$graczBiale}}</td>
					<td> @if($graczBiale == $nick)(Ty)@php $kol = 1; @endphp @endif</td>
				</tr>
				<tr>
					<td><img src="{{$folder}}/images/15.png" alt="czarne"></td>
					<td>{{$graczCzarne}}</td>
					<td> @if($graczCzarne == $nick)(Ty)@php $kol = 2; @endphp @endif</td>
				</tr>
			</table>
			<br>
			<br>
					&nbsp; &nbsp; tura: <span id="tura" @if($tura != $kol) class="red" @endif>
						@if($tura == $kol) Twoja kolej @else Przeciwnika @endif
					</span><br>
			<br>
			<button onclick="poddaj();" style="background: red">Poddaj się</button>
			<br>
			<form action="" method="POST">
				{{@csrf_field()}}
				<input type="submit" name="wyloguj" value="Wyloguj">
			</form>
			<br>
		</section>
	</main>
	<div id="wymiana" @if($wymiana != 0 && $tura == $kol) style="display:block" @endif>
		Wybierz figurę na wymianę z pionem:<br>
		<div id="wymianaContent">
			@if($wymiana != NULL && $tura == $kol)
				@if($wymiana > 10)
					<img src='images/11.png' alt='figura' onclick='wymiana({{$wymiana}},11)'>
                	<img src='images/12.png' alt='figura' onclick='wymiana({{$wymiana}},12)'>
                	<img src='images/13.png' alt='figura' onclick='wymiana({{$wymiana}},13)'>
                	<img src='images/14.png' alt='figura' onclick='wymiana({{$wymiana}},14)'>
				@else
					<img src='images/31.png' alt='figura' onclick='wymiana({{$wymiana}},31)'>
                	<img src='images/32.png' alt='figura' onclick='wymiana({{$wymiana}},32)'>
                	<img src='images/33.png' alt='figura' onclick='wymiana({{$wymiana}},33)'>
                	<img src='images/34.png' alt='figura' onclick='wymiana({{$wymiana}},34)'>
				@endif
			@endif
		</div>
	</div>
	<script type="text/javascript"> sprawdz2();</script>
@endsection