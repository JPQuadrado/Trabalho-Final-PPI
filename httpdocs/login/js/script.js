document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("#form-login");

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

        if (resposta.success){
            window.location = resposta.detail;
        }
        else {
            document.querySelector("#login-fail").style.display = 'block';
            form.senha.value = "";
            form.senha.focus();
        }
    }      

      xhr.send(new FormData(form));

}