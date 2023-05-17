document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("#form-cadastro")
    const inputEmail = document.querySelector("#email");
    //inputEmail.disabled = true;

    form.onsubmit = function(e){
        enviaForm(form);
        e.preventDefault();
    }

    buscaInformacoes();
});

function buscaInformacoes(){
}

function enviaForm(form){
    let formData = new FormData(form);
    let xhr = new XMLHttpRequest();

    xhr.open("POST", form.getAttribute("action"));
    xhr.responseType = 'json';

    xhr.onload = function () {
        let resposta = xhr.response;

        if (resposta.success){
            window.location = resposta.detail;
        }
        else {
            document.querySelector("#att-fail").style.display = 'inline';
            form.senhaAntiga.value = "";
            form.senhaNova.value = "";
            form.senhaAntiga.focus();
        }
    }      

    xhr.send(formData);
}