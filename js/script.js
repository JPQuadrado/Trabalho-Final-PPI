document.addEventListener("DOMContentLoaded", function () {
  buscaAvancada();
  buscaCategorias();
});

window.onload = function () {
  loadProducts();
}

window.onscroll = function () {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    loadProducts();
  }
};

function buscaAvancada() {
  const search = document.querySelector("#btn-advanced");
  const divAdvanced = document.getElementById("search-advanced");
  let foo = false;

  search.onclick = function () {
    divAdvanced.style.display = "block";
    if (foo) {
      divAdvanced.style.display = "none";
      foo = false;
    } else {
      divAdvanced.style.display = "block";
      foo = true;
    }
  };
}

function buscaCategorias() {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "buscaCategoria.php");

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
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
      categorias.forEach(function (categoria) {
        var div = document.createElement("div");
        var input = document.createElement("input");
        var label = document.createElement("label");
        input.setAttribute("type", "checkbox");
        input.setAttribute(
          "name",
          categoria.nome
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
        );
        input.setAttribute(
          "id",
          categoria.nome
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
        );
        input.setAttribute("value", categoria.codigo);
        label.setAttribute(
          "for",
          categoria.nome
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
        );
        label.textContent = categoria.nome;

        div.appendChild(input);
        div.appendChild(label);
        divCategorias.appendChild(div);
      });
    }
  };

  xhr.send();
}

async function loadProducts() {
  try {
    let resposta = await fetch("buscaProduto.php");
    if (!resposta.ok) throw new Error(resposta.statusText);
    var anuncios = await resposta.json();
    
  } catch (e) {
    console.error(e);
    return;
  }

  renderAnuncios(anuncios);
}

function renderAnuncios(anuncios) {

  const anuncioSection = document.querySelector(".results_search");
  const template = document.querySelector("#template");

  for (let anuncio of anuncios) {
    let html = template.innerHTML
      .replace("{{anuncio-image}}", anuncio.imagem)
      .replace("{{anuncio-titulo}}", anuncio.nome)
      .replace("{{anuncio-descricao}}", anuncio.descricao)
      .replace("{{anuncio-preco}}", anuncio.preco)
      .replace("{{anuncio-codigo}}", anuncio.codigo);

      anuncioSection.insertAdjacentHTML("beforeend", html);
  };
}