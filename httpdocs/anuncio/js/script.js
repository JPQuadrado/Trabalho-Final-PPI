const imgAnuncioDetalhado = document.querySelector(".img-div-anuncio");
const btnAnuncioDetalhado = document.querySelector(".btn-div-anuncio");
const opcoesImgAnuncio = ["/anuncio/img/caneca1.jpg", "/anuncio/img/caneca2.jpg", "/anuncio/img/caneca3.jpg", "/anuncio/img/caneca4.jpg"]
var index = 0;

btnAnuncioDetalhado.onclick = function(){
    index += 1;
    index = index % opcoesImgAnuncio.length;
    
    imgAnuncioDetalhado.setAttribute('src', opcoesImgAnuncio[index])
}

document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector(".interesse-form");

    form.onsubmit = function (e) {
        enviaForm(form);
        e.preventDefault();
    }
});

function enviaForm(form){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", form.getAttribute("action"));
    xhr.responseType = 'json';

    xhr.onload = function () {
        let resposta = xhr.response;
        console.log(resposta);
        if (resposta.success){
            alert(resposta.detail);
        }
        else {
            alert(resposta.detail);
        }
    }      

    xhr.send(new FormData(form));

}
