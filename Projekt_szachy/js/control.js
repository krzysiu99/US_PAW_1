var uklad = [];

function ruch(figura,poleZrodlo,poleCel){
    $.ajax({
		type: "POST",
		url: "index.php",
		data: {
			figura: figura,
            poleCel: poleCel,
            poleZrodlo, poleZrodlo
		},
		success: function (msg) {
            uklad = msg;
            aktualizuj();
		},
		error: function (xhr, status, error) {
			alert(error);
		}
	});
}

function aktualizuj(){
    uklad1 = uklad.split("|");
    for(i=1;i<=8;i++){
        if(uklad1[i] != undefined && uklad1[i] != "") {
            uklad2 = uklad1[i].split(".");
            for(j=1;j<=8;j++){
                if(uklad2[j] != undefined && uklad2[j] != ""){
                    //elem = uklad2[j].split(",");
                    uklad3 = uklad2[j].split(",");
                    $('#pole-'+i+'-'+j).html("<img src='images/" + uklad3[0] + ".png' alt='figura' id='figura-" + uklad3[0] + "' class='" + uklad3[1] + "'>");
                } else $('#pole-'+i+'-'+j).html("");
            }
        }
    }
    interfejs();
}

$(document).ready(function() {
    interfejs();
});

function interfejs(){
    
    $(".figuraMoja").draggable({
        //handle: '.storI',
        containment: 'table',
        start: function(element) {
            var draggableId = $(this).attr("id");
            elem = draggableId.split("-");
            var element = $(this).parent();
            element.css("background-image","url('images/back/"+elem[1]+".png')");
        },
        stop: function(element) {
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