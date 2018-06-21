var tableau = [];
var nbItemPerPage = 4;
var url = '';

function display(database, gotoUrl){
  url = gotoUrl;
  getData(database,function(){
    data = this;
    for(var x in data){
      tableau.push(data[x]);
    }
    if (tableau.length == 4) { nbItemPerPage = 4;}
    creerBouton(0);
  });
}

function getData(database,callback) {
  var xhr;
  if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhr.open("GET", "select.php?database=" + database, true);
  xhr.setRequestHeader('Content-Type', 'application/json');
  xhr.send();
  xhr.onreadystatechange = function() {
  if (xhr.readyState == 4) {
    if (xhr.status == 200) {
    var data = eval(xhr.responseText);
    callback.call(data);
  }};
  }
}

function creerBouton(debut) {
  var div = document.getElementById('choix');
  while(div.firstChild){
    div.removeChild(div.firstChild);
  }

  var x ;
  for (x=debut ; x<=debut+(nbItemPerPage-1) ; x++) {
    if (x < tableau.length) {
      var btn   = document.createElement("input" ) ;
      btn.type  = "button" ;
      btn.value = tableau[x].libelle;
      btn.id    = tableau[x].id;
      btn.style.width = '100%';
      btn.style.marginBottom = '10px';
      btn.style.height = '40px';
      btn.style.fontSize = '16px';
      btn.onclick = function() {location.href=url+this.id ;}
      document.getElementById("choix").appendChild(btn);
    }
  }

  if (tableau.length > nbItemPerPage) {
    debut = (x >= tableau.length)? 0 : x;
    var btn = document.createElement("input" ) ;
        btn.type = "button" ;
        btn.value = "PAGE SUIVANTE >>" ;
        btn.style.width = '100%';
        btn.style.marginBottom = '10px';
        btn.style.height = '40px';

        btn.onclick = function() {creerBouton(debut)}
        document.getElementById("choix").appendChild(btn) ;
  }
}