@extends('layouts.app')
@section('head') @endsection
@section('content')
    <div id="wrapper">
        <section class="left">
            <img src="{{asset('images/logo.png')}}" alt="logo">

            @if($msg->display() != NULL)
                <div id="error">{{$msg->display()}}</div>
            @elseif($wyloguj)
                <div id="error" style="background: rgb(72, 212, 72)">Wylogowano</div>
            @else
                <div id="error" style="visibility: hidden">&nbsp;</div>
            @endif

            <form action="/" method="POST">
                {{@csrf_field()}}
                <img src="{{asset('images/user.png')}}" alt="user" class="icon">
                <input type="text" name="login" placeholder="login" minlength="3" maxlength="15" pattern="[A-Za-z0-9]+"><br>
                <small>długość 3 - 15, dozwolone litery oraz cyfry</small><br>

                <img src="{{asset('images/lock.png')}}" alt="lock" class="icon">
                <input type="password" name="haslo" placeholder="hasło" minlength="3" maxlength="30"><br>
                <small>długość 3 - 30, dowolne znaki</small><br>

                <input type="submit" class="left" name="zaloguj" value="zaloguj się" >
                <input type="submit" class="right" name="zarejestruj" value="zarejestruj się">
                <br>
            </form>
        </section>
        <section class="right">
            <h1>Szachy online</h1>
            <p>
                Przeglądarkowa gra wieloosobowa szachy umożliwia zapraszanie graczy online do rozgrywki.<br><br>
                Po uruchomieniu nowej gry gracze losują strony. Podczas swojej tury gracz może poddać się. Gra kończy się gdy król zostanie zbity.<br>
                Kiedy pion dotrze do końca planszy musi zostać wymieniony na jedną z 4 figur (król, królowa, wieża, koń).
            </p>
            <br><br><br>
            &copy; Krzysztof Niestrój 2021.<br>
            Obrazy pochodzą z stron z darmową grafiką.
        </section>
    </div>
@endsection