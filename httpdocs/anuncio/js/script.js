const imgAnuncioDetalhado = document.getElementById("img-div-anuncio");
const btnAnuncioDetalhado = document.getElementById("btn-div-anuncio");
const opcoesImgAnuncio = ["/anuncio/img/caneca1.jpg", "/anuncio/img/caneca2.jpg", "/anuncio/img/caneca3.jpg", "/anuncio/img/caneca4.jpg"]
var index = 0;

btnAnuncioDetalhado.onclick = function(){
    index += 1;
    index = index % opcoesImgAnuncio.length;
    
    imgAnuncioDetalhado.setAttribute('src', opcoesImgAnuncio[index])
}
