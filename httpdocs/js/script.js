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