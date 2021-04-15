@extends('layouts.app')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    @if($msg != NULL)
        @foreach($msg as $e)
            <div style="position: fixed;top: 50px; left: 10px; width: calc(100vh - 20px); background: red; color: white; text-align: center;">{{$e}}</div>
        @endforeach
    @endif
    <div id="bigwrapper">
        <section class="left">
            <h1>Oczekujący gracze online</h1>
            <span class="info">
                wybierz gracza aby wysłać zaproszenie do gry, lista odświerzana jest co pięć sekund
            </span>

            <table class="lista">
                <thead>
                    <tr>
                        <th>nick gracza</th>
                        <th><img src="{{$folder}}/images/wygrane.png" alrt="wygrane" title="wygrane"></th>
                        <th>Zaproś</th>
                    </tr>
                </thead>
                <tbody id="lista1">
                    @php $linie = 0; @endphp
                    @if(count($gracze)>0)
                        @foreach($gracze as $g)
                            @php $linie++; @endphp
                            <tr>
                                <td>{{$g[0]}}</td>
                                <td>{{$g[1]}}</td>
                                <td>
                                    @if($g[2] == 0)
                                        <a href="javascript:void(0)" onclick="zapros('{{$g[0]}}')">Zaproś</a>
                                    @elseif($g[2] == 2)
                                        &nbsp;
                                    @else
                                        Zaproszono
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @php $linie++; @endphp
                        <tr>
                            <td colspan="3" style="color: rgb(189, 189, 189);text-align: center;">[ Brak aktywnych graczy ]</td>
                        </tr>
                    @endif
                    @for($i=$linie;$i<=4;$i++)
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

        </section>
        <section class="right">
            <h1>Zaproszenia do rozgrywki</h1>
                <span class="info">
                    lista gracz którzy zaprosili Cię do gry, uruchomienie gry anuluje wszystkie inne zaproszenia
                </span>

                <table class="lista">
                <thead>
                    <tr>
                        <th>nick gracza</th>
                        <th><img src="{{$folder}}/images/wygrane.png" alrt="wygrane" title="wygrane"></th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody id="lista2">
                    @php $linie = 0; @endphp
                    @if(count($zaproszenia)>0)
                        @foreach($zaproszenia as $a)
                            @php $linie++; @endphp
                            <tr>
                                <td>{{$a[0]}}</td>
                                <td>{{$a[1]}}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="akceptuj('{{$a[0]}}')">Akceptuj</a>&nbsp;|
                                    <a href="javascript:void(0)" onclick="odrzuc('{{$a[0]}}')">Odrzuć</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @php $linie++; @endphp
                        <tr>
                            <td colspan="3" style="color: rgb(189, 189, 189);text-align: center;">[ Brak aktywnych zaproszeń ]</td>
                        </tr>
                    @endif
                    @for($i=$linie;$i<=4;$i++)
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    @endfor
                </tbody>
            </table>

        </section>
        <section class="down">
            <form action="{{$folder}}/index.php" method="POST">
                {{@csrf_field()}}
                Gracz: {{$user->getLogin()}} <input type="submit" name="wyloguj" value="wyloguj"><br>
                Wygrane: {{$wygrane}}<br>
                Rejestracja/ostatnia gra: {{$ostGra}} (jeśli nie zagrasz w ciągu {{$pozostalo}} dni Twoje konto zostanie usunięte)
            </form>
        </section>
    </div>
    <script type="text/javascript"> czekaj(); </script>
@endsection