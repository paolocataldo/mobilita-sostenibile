function controllaForm(){
    var email = document.getElementById("email").value;
    var conferma_email = document.getElementById("conferma_email").value;
    var password = document.getElementById("password").value;
    var conferma_password = document.getElementById("conferma_password").value;

    if(email != conferma_email){
        alert("Le email non coincidono!");
        return false;
    }
    if(password != conferma_password){
        alert("Le password non coincidono!");
        return false;
    }
    return true;
}

function caricaClassi() {
    let scuola_id = document.getElementById("scuola").value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "../includes/get_classi.php?scuola_id=" + scuola_id, true);

    xhr.onload = function () {
        if (this.status == 200) {
            document.getElementById("classe").innerHTML = this.responseText;
        }
    };

    xhr.send();
    console.log(scuola_id);
}

