const imgAnuncioDetalhado = document.getElementById("img-div-anuncio");
const btnAnuncioDetalhado = document.getElementById("btn-div-anuncio");
const opcoesImgAnuncio = ["../img/caneca1.jpg", "../img/caneca2.jpg", "../img/caneca3.jpg", "../img/caneca4.jpg"]
var index = 0;

btnAnuncioDetalhado.onclick = function(){
    index += 1;
    index = index % opcoesImgAnuncio.length;
    
    imgAnuncioDetalhado.setAttribute('src', opcoesImgAnuncio[index])
}
