function nuovaPassword(){
    var password = document.getElementById("password").value;
    var conferma_password = document.getElementById("conferma_password").value;

    if(password != conferma_password){
        alert("Le password non coincidono!");
        return false;
    }
    return true;
}