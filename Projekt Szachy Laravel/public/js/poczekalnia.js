/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

var status = true;

$.ajaxSetup({ //dla lavarela
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});

function aktualizuj(msg){ //aktualizuj listę dynamicznie
    if(msg == "1" || msg[0] == "<"){
        window.location.href = window.location.href;
    } else {
        N = "";
        N2 = "";
        msg = msg.split(" || ");
        a = 0; aa = 0;
        for(var i = 0; msg[i] != undefined; i++){
            msg2 = msg[i].split(" | ");
            if(msg2[0] != undefined && msg2[0] != ""){
                a++;
                if(msg2[2] == "0")
                    b = "<a href='javascript:void(0)' onclick='zapros(" + msg2[3] + ")'>Zaproś</a>";
                else if(msg2[2] == "2"){
                    b = "";
                    aa++
                    N2 += "<tr><td>" + msg2[0] + "</td><td>" + msg2[1] + "</td><td><a href='javascript:void(0)' onclick='akceptuj(" + msg2[3] + ")'>Akceptuj</a>&nbsp;|&nbsp;<a href='javascript:void(0)' onclick='odrzuc(" + msg2[3] + ")'>Odrzuć</a></td></tr>";
                } else b = "Zaproszono";
                N += "<tr><td>" + msg2[0] + "</td><td>" + msg2[1] + "</td><td>" + b + "</td></tr>";
            }
        }
        if(a == 0) {
            N += "<tr><td colspan='3' style='color: rgb(189, 189, 189);text-align: center;'>[ Brak aktywnych graczy ]</td></tr>";
            a++;
        }
        if(aa == 0) {
            N2 += "<tr><td colspan='3' style='color: rgb(189, 189, 189);text-align: center;'>[ Brak aktywnych zaproszeń ]</td></tr>";
            aa++;
        }
        for(i=a;i<5;i++) N += "<tr><td colspan='3' style='color: rgb(189, 189, 189);text-align: center;'>&nbsp;</td></tr>";
        for(i=aa;i<5;i++) N2 += "<tr><td colspan='3' style='color: rgb(189, 189, 189);text-align: center;'>&nbsp;</td></tr>";
        $('#lista1').html(N);
        $('#lista2').html(N2);
    }
}

function sprawdz(){ //sprawdzanie dynamiczne przez ajax listy graczy
    status = true;

    $.ajax({
		type: "POST",
		url: "index.php",
		data: {
			sprawdz: 1
		},
		success: function (msg) {
            aktualizuj(msg);
            status = false;
		},
		error: function (xhr, stat, error) {
            alert(xhr + stat + error);
			status = false;
		}
	});
}

function czekaj(){ //co 5 sekund sprawdź listę
    const loop = setInterval(function(){
        if(status) sprawdz();
    } ,5000);
}

function zapros(nick){ //zaproś do gry
    if(status){
        status = false;

        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                zapros: nick
            },
            success: function () {
                sprawdz();
            },
            error: function (xhr, status, error) {
                alert(xhr + status + error);
            }
        });
    }
}

function odrzuc(nick){ //odrzuć zaproszenie
    if(status){
        status = false;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                odrzuc: nick
            },
            success: function (msg) {
                //alert(msg);
                sprawdz();
            },
            error: function (xhr, status, error) {
                alert(xhr + status + error);
            }
        });
    }
}

function akceptuj(nick){ //akceptuj zaproszenie
    if(status){
        status = false;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                akceptuj: nick
            },
            success: function () {
                sprawdz();
            },
            error: function (xhr, status, error) {
                alert(xhr + status + error);
            }
        });
    }
}