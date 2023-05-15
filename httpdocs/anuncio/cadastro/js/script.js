document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("#form-cadastro");

    form.onsubmit = function(e){
        enviaForm(form);
        e.preventDefault();
    }
});

function enviaForm(form){
    let formData = new FormData(form);
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../cadastroAnuncio.php");
    console.log(xhr.responseType());
    xhr.send(formData);
}