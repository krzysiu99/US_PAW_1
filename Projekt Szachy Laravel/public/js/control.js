/*                    Projekt Szachy Online                        */
/*  Języki Programowania Dynamicznych Stron Internetowych          */
/*                     Krzysztof Niestrój                          */
/*              krzysztof.niestroj@o365.us.edu.pl                  */
/*                     Framework Laravel                           */
/*                         10.05.2021                              */

var uklad = [];
var blokada = false;

$.ajaxSetup({ //dla lavarela
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ruch(figura,poleZrodlo,poleCel){ //wykonaj ruch
    blokada = true;
    $.ajax({
        type: "POST",
        url: "index.php",
        data: {
            figura: figura,
            poleCel: poleCel,
            poleZrodlo, poleZrodlo
        },
        success: function (msg) {
            if(msg[0] == "<") window.location.href = window.location.href;
            else if(msg == "Niestroj2021") window.location.href = window.location.href;
            uklad = msg;
            aktualizuj2();
        },
        error: function (xhr, status, error) {
            alert(error);
        }
    });
}

function poddaj(){ //poddaj się
    if(!blokada){ //sprawdzanie czy działa już jakiś inny skrypt, jeśli tak to blokada = true
        blokada = true;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                poddaj: 1
            },
            success: function (msg) {
                if(msg == "Niestroj2021") window.location.reload();
                else alert(msg);
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }
}

function sprawdz2(){ //dynamiczne sprawdzanie układu szachownicy
    if(!blokada){
        blokada = true;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                sprawdz2: 1
            },
            success: function (msg) {
                if(msg[0] == "<" || msg[0] == "Niestroj2021") window.location.href = window.location.href;
                uklad = msg;
                aktualizuj2();
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }
}

function aktualizuj2(){ //aktualizowanie układu szachownicy
    uklad = uklad.split(" ||| ");
    wymianaV = uklad[2];
    uklad1 = uklad[0].split("|");
    for(i=1;i<=8;i++){
        if(uklad1[i] != undefined && uklad1[i] != "") {
            uklad2 = uklad1[i].split(".");
            for(j=1;j<=8;j++){
                if(uklad2[j] != undefined && uklad2[j] != ""){
                    uklad3 = uklad2[j].split(",");
                    if(uklad[1] == 0 || wymianaV != "0") uklad3[1] = "figuraWroga";
                    $('#pole-'+i+'-'+j).html("<img src='images/" + uklad3[0] + ".png' alt='figura' id='figura-" + uklad3[0] + "' class='" + uklad3[1] + "'>");
                } else $('#pole-'+i+'-'+j).html("");
            }
        }
    }
    historia = uklad[3];
    $('#historiaRuchow').html('');
    hi = 0;
    if(historia != ""){
        if(historia == undefined) window.location.href = window.location.href;
        historia =  historia.split('**');
        for(i=0;historia[i] != undefined;i++){
            h = historia[i].split('*');
            $('#historiaRuchow').html($('#historiaRuchow').html() + '<tr><td><img src="images/'+h[0]+'.png" alt="figura"></td><td>'+h[1]+'</td><td>'+h[2]+'</td></tr>');
            hi++;
        }
    }
    for(i=hi;i<=10;i++){
        $('#historiaRuchow').html($('#historiaRuchow').html() + '<tr><td colspan="3">&nbsp;</td></tr>');
    }
    blokada = false;
    interfejs();
    if(uklad[1] == 0) {
        $('#tura').html();
        $('#tura').html('Przeciwnika');
        $('#tura').addClass('red');
        $('#wymiana').css('display','none');
        czekaj2();
    } else {
        $('#tura').html('Twoja kolej');
        $('#tura').removeClass('red');
        if(wymianaV != "0"){
            $('#wymiana').css('display','block');
            N = "";
            if(parseInt(wymianaV)>10){
                N += "<img src='images/11.png' alt='figura' id='figura-w-11' onclick='wymiana("+wymianaV+",11)'>&nbsp;";
                N += "<img src='images/12.png' alt='figura' id='figura-w-12' onclick='wymiana("+wymianaV+",12)'>&nbsp;";
                N += "<img src='images/13.png' alt='figura' id='figura-w-13' onclick='wymiana("+wymianaV+",13)'>&nbsp;";
                N += "<img src='images/14.png' alt='figura' id='figura-w-14' onclick='wymiana("+wymianaV+",14)'>&nbsp;";
            } else {
                N += "<img src='images/31.png' alt='figura' id='figura-w-31' onclick='wymiana("+wymianaV+",31)'>&nbsp;";
                N += "<img src='images/32.png' alt='figura' id='figura-w-32' onclick='wymiana("+wymianaV+",32)'>&nbsp;";
                N += "<img src='images/33.png' alt='figura' id='figura-w-33' onclick='wymiana("+wymianaV+",33)'>&nbsp;";
                N += "<img src='images/34.png' alt='figura' id='figura-w-34' onclick='wymiana("+wymianaV+",34)'>";
            }
            $('#wymianaContent').html(N);
            czekaj2();
        } else $('#wymiana').css('display','none');
    }
}

function wymiana(pozycja,figura){ //wymiana piona
    if(!blokada){
        blokada = true;
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                wymiana: pozycja,
                figura: figura
            },
            success: function (msg) {
                //if(msg[0] == "<") window.location.href = window.location.href;
                uklad = msg;
                aktualizuj2();
            },
            error: function (xhr, status, error) {
                alert(error);
            }
        });
    }
}

function interfejs(){ //ożywienie interfejsu - aktywacja przesuwania figur
    
    $(".figuraMoja").draggable({
        //handle: '.storI',
        containment: 'table',
        start: function(element) {
            blokada = true;
            var draggableId = $(this).attr("id");
            elem = draggableId.split("-");
            var element = $(this).parent();
            element.css("background-image","url('images/back/"+elem[1]+".png')");
            element.css("background-size","87%");
            element.css("background-position","center");
            element.css("background-repeat","no-repeat");
        },
        stop: function(element) {
            blokada = false;
            var draggableId = $(this).attr("id");
            $("#"+draggableId).css("inset","auto");
            $("td").removeClass("aktywne");
            $("td").css("background-image","unset");
        }
    });
    $('.pole').droppable({
        over: function(event, ui) {
            var droppableId = $(this).attr("id");
            $("#" +  droppableId).addClass("aktywne");
        },
        out: function(event, ui) {
            var droppableId = $(this).attr("id");
            $("#" +  droppableId).removeClass("aktywne");
        },
        drop: function(event, ui){
            var draggableId = ui.draggable.attr("id");
            var zrodlo = ui.draggable.parent().attr("id");;
            var droppableId = $(this).attr("id");

            figura = draggableId.split("-");
            pole = droppableId.split("-");
            if(figura != undefined && pole != undefined && zrodlo != undefined && zrodlo != droppableId) ruch(figura[1], zrodlo, pole[1] + "-" + pole[2]);
        }
    });
}

function czekaj2(){ //co 5 sekund sprawdzanie układu gry
    const loop = setInterval(function(){
        sprawdz2();
        clearInterval(loop);
    } ,5000);
}