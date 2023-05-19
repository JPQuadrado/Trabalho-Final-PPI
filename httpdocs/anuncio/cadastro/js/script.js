document.addEventListener("DOMContentLoaded", function(){

    const inputCep = document.querySelector("#cep");


    inputCep.addEventListener("keyup", function(){
        buscaEndereco(inputCep.value);
    });


    buscaCategorias();

});

function buscaCategorias(){
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

function buscaEndereco(valorCep){
    let xhr = new XMLHttpRequest();
    let objeto = {
        cep:valorCep
    }
    xhr.open("POST", "buscaEndereco.php");
    xhr.setRequestHeader("Content-Type", "application/json");
    
    if(valorCep.length != 9) return;
    
    xhr.onreadystatechange = function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            /**
             * Transforma o objeto json vindo do buscaEndereco em um objeto javascript
             * E atualiza dinamicamente o value do form.
             */
            const endereco = JSON.parse(xhr.response);
            let form = document.querySelector("#form-cadastro");
            form.bairro.value = endereco.bairro
            form.cidade.value = endereco.cidade;
            form.estado.value = endereco.estado;
        }
    };



    xhr.send(JSON.stringify(objeto));
}