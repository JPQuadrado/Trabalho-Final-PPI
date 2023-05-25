document.addEventListener("DOMContentLoaded", function(){
    buscaAvancada();
    buscaCategorias();
});

function buscaAvancada(){
    const search = document.getElementById("search-div-btn-advanced");
    const divAdvanced = document.getElementById("search-advanced");
    let foo = false;
    
    search.onclick = function(){
        divAdvanced.style.display = 'block'
        if(foo){
            divAdvanced.style.display = 'none'
            foo = false;
        }
        else{
            divAdvanced.style.display = 'block';
            foo = true;
        }
    };   
}

function buscaCategorias(){
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "buscaCategoria.php");

    xhr.onreadystatechange = function(){
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            // Converte a resposta json em objeto JS.
            var categorias = JSON.parse(xhr.responseText);
            const divCategorias = document.getElementById("categorias");
            
            /**
             * Faz um forEach no array recebido pelo servidor
             * E cria uma nova div para cada categoria.
             * 
             * OBS: .toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "")
             * serve para retirar a acentuação e transformar em minúsculo.
             * O name, id e for sem ela ficaria igual o nome cadastrado no banco (ex: Veículos)
             * e não funcionaria no request.
             */
            categorias.forEach(function(categoria){
                var div = document.createElement("div");
                var input = document.createElement("input");
                var label = document.createElement("label");
                input.setAttribute("type", "checkbox");
                input.setAttribute("name", categoria.nome.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ""));
                input.setAttribute("id", categoria.nome.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ""));
                input.setAttribute("value", categoria.codigo);
                label.setAttribute("for", categoria.nome.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, ""));
                label.textContent = categoria.nome;

                div.appendChild(input);
                div.appendChild(label);
                divCategorias.appendChild(div);
            });
        }
    };

    xhr.send();
}
