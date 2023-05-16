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

    xhr.open("POST", "cadastroAtualiza.php");
    console.log(xhr.responseText);
    xhr.send(formData);
}