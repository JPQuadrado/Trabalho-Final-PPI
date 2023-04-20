const search = document.getElementById("search");
const divAdvanced = document.getElementById("search-advanced");
let searchAc = false, divAc = false;

search.onclick = function(){
    divAdvanced.style.visibility = 'visible'
};

search.addEventListener("onfocusout", function(){
    divAdvanced.style.visibility = 'visible'

});

divAdvanced.addEventListener("mouseleave", function(){
    divAdvanced.style.visibility = 'hidden';
});

if(searchAc){
    divAdvanced.style.visibility = 'hidden';
}