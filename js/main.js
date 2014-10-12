function tourneeJour () {
    $.post ("tourneesAll.php", {date:"jour"} , function(data){
        $( "#data" ).empty().append( data );
    });
}

function tourneeSemaine () {
    $.post ("tourneesAll.php", {date:"semaine"} , function(data){
        $( "#data" ).empty().append( data );
    });
}


$(document).ready(function(evt) {
    $("#tourneeJ").on('click',function(e) { e.preventDefault(); tourneeJour(); });
    $("#tourneeS").on('click',function(e) { e.preventDefault(); tourneeSemaine(); });
    tourneeJour();
});
