
alert("works");
/*var divElm = document.getElementById("doc_92422"); 
alert(divElm);
*/
var bodyElm = window.frames['doc_92422'];

var scribd = bodyElm.contentDocument.createElement("style"); 
scribd.type = "text/css"; 
scribd.async = true; 
scribd.src = "http://www.hoveron.net/WitanWorld/wordpress/wp-content/themes/primer/assets/css/witan/charts.css"; 
var s = bodyElm.contentDocument.getElementsByTagName("head")[0];
s.appendChild(scribd);