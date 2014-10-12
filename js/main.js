function tourneeJour (arg) {
    $.post ("tourneesAll.php", {date:arg} , function(data){
        $( "#data" ).empty().append( data );
    });
}

function tourneeAnnee () {
    $.post ("tourneesJour.php", function(data){
        $( "#data" ).empty().append( data );
    });
}


$(document).ready(function(evt) {
    $("#tourneeJ").on('click',function(e) { e.preventDefault(); tourneeJour("jour"); });
    $("#tourneeS").on('click',function(e) { e.preventDefault(); tourneeJour("semaine"); });
    $("#tourneeA").on('click',function(e) { e.preventDefault(); tourneeAnnee(); });
    tourneeJour("jour");
});
