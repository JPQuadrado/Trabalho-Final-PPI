document.addEventListener("DOMContentLoaded", function(){
    const form = document.querySelector("#form-cadastro");

    form.onsubmit = function(e){
        enviaForm(form);
        e.preventDefault();
    }

    buscarCategorias();
});

function enviaForm(form){
    let formData = new FormData(form);
    let xhr = new XMLHttpRequest();

    xhr.open("POST", "../cadastroAnuncio.php");
    
    xhr.send(formData);
}

function buscarCategorias(){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "buscaCategoria.php");

    xhr.onreadystatechange = function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            // Converte a resposta json em objeto JS.
            var categorias = JSON.parse(xhr.responseText);
            const select = document.getElementById("categoria");
            
            /**
             * Faz um forEach no array recebido pelo servidor
             * E cria uma nova opção no select dinamente.
             */
            categorias.forEach(function(categoria){
                var opcao = document.createElement('option');
                opcao.value = categoria.codigo;
                opcao.text = categoria.nome;
                select.add(opcao);
            });
        }
    };

    xhr.send();
}