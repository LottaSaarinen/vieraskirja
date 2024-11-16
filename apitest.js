// ============== MINIMAL APITEST ================================================================
// 
// (c) 2020-2024 Peter Forsell
//
// suorita tämä konsolista komennolla 
//         node apitest.js 4
// jossa viimeisenä oleva numero on halutun vieraskirjaviestin vid (perusavain)
// node.js pitää olla asennettuna
//
// selaimella sama onnistuu syöttämällä URL:
//   http://neutroni.hayo.fi/~peterf/apidemo/apihaku.php?vid=5
// 
//   http://neutroni.hayo.fi/~peterf/vieras
//
// =================================================================================================var http = require('https');

// haetaan komentorivilta pyydetty viesti_id 
let viesti_id = parseInt(process.argv.slice(2));


// ellei se ole numero, ei voida jatkaa
if (isNaN(viesti_id)) {
  console.log("Virheellinen viesti_id");
  process.exit(1);
}


// palvelin ja polku datajäseninä uuteen olioon nimeltä osoite
// tämän olion rakenne määrätään http.ClientRequest -luokassa
var osoite = {
    host: 'neutroni.hayo.fi',
    path: '/~lsaarinen/be/vieraskirja/api.php/vid=' + viesti_id
}


// globaali muuttuja sisaantulevan datan varastointiin
var varasto = '';


// http.request() -metodi palauttaa http.ClientRequest -luokan olion muuttujaan yht
// tässä vaiheessa yhteydenotto palvelimeen on jo tehty ja odotellaan vastauksia
// tämä olio sisältää datajäsenenään res-olion
// kuuntelija() on callback-funktio jota yht kutsuu käsitelläkseen saapuvat vastaukset
// kaikki tietoliikenne tapahtuu tässä, ks. alempana kuuntelija() -funktion määrittely
var yht = http.request(osoite, kuuntelija);


// jos yht vastaanottaa 'error' tapahtuman palvelimesta
// lähettää virheolion parametrina callback-funktiolle yhteysvirhe()
yht.on('error', yhteysvirhe);


// suljetaan yhteys
yht.end();





// =========== CALLBACK-FUNKTIOT =========================================================


// ************** yht-olion callback-funktio kuuntelija() ************

// kuuntelija() vastaanottaa yht-olion saamat vastaukset palvelimesta
// res-olio on yht-olion sisäinen datajäsen ja osa http.ClientRequest() -luokkaa
// res on EventEmitter-luokan olio ja sen asynkroninen on-metodi [ eli res.on() ] 
// odottaa kahta nimettyä tapahtumaa tapahtuviksi, 'data' ja 'end'
//    1. kun tapahtuu 'data' se kutsuu funktiota luekikkare() ja lähettää sille parametrina saapuneen datan
//       jonka jälkeen se jatkaa odottamista
//    2. kun tapahtuu 'end' se kutsuu funktiota tulosta() ja lopettaa tapahtumien odottamisen

function kuuntelija(res) {
    res.on('data', luekikkare);
    res.on('end', tulosta);
}


// ************** yht-olion callback-funktio yhteysvirhe() ************

// tulostaa näytölle parametrina saapuneen virheolion virhe sisältämän messagen
function yhteysvirhe(virhe) {
    console.log(virhe.message);
}




// ************ res-olion callback-funktio luekikkare() ***************

// taltioi saapuneen datakikkareen globaaliin muuttujaan varasto
// data tulee parametrina res-oliolta, joka välittää sen tälle callback-funktiolle
//
// saapuva data on alunperin peräisin web-palvelimesta, josta se saapui yht-oliolle, joka on
// välittänyt sen kuuntelija()-funktion kautta res-oliolle, joka 
// välittää sen tähän luekikkare()-funktioon
function luekikkare(uuttadataa) {
  varasto += uuttadataa; 
}



// ************ res-olion callback-funktio tulosta() ***************

// tulosta naytölle kaikki saapunut data yhdellä kerralla
function tulosta() {
   console.log(varasto);
}




