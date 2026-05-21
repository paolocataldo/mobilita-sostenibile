function controllaForm(){

    var email =
        document.getElementById("email").value;

    var conferma_email =
        document.getElementById("conferma_email").value;

    var password =
        document.getElementById("password").value;

    var conferma_password =
        document.getElementById("conferma_password").value;

    var usernameMessage =
        document.getElementById("username_message").textContent;

    var emailMessage =
        document.getElementById("email_message").textContent;

    /* CONTROLLO EMAIL */
    if(email != conferma_email){

        alert("Le email non coincidono!");
        return false;
    }

    /* CONTROLLO PASSWORD */
    if(password != conferma_password){

        alert("Le password non coincidono!");
        return false;
    }

    /* CONTROLLO USERNAME */
    if(usernameMessage == "Username già utilizzato!"){

        alert("Username già utilizzato!");
        return false;
    }

    /* CONTROLLO EMAIL ESISTENTE */
    if(emailMessage == "Email già registrata!"){

        alert("Email già registrata!");
        return false;
    }

    return true;
}

/* CARICA CLASSI */
function caricaClassi() {

    let scuola_id =
        document.getElementById("scuola").value;

    let xhr = new XMLHttpRequest();

    xhr.open(
        "GET",
        "../includes/get_classi.php?scuola_id=" + scuola_id,
        true
    );

    xhr.onload = function () {

        if (this.status == 200) {

            document.getElementById("classe").innerHTML =
                this.responseText;
        }
    };

    xhr.send();
}

/* ELEMENTI */
const username =
    document.getElementById("username");

const email =
    document.getElementById("email");

const password =
    document.getElementById("password");

/* MESSAGGI */
const usernameMessage =
    document.getElementById("username_message");

const emailMessage =
    document.getElementById("email_message");

const passwordMessage =
    document.getElementById("password_message");

/* CONTROLLO USERNAME */
username.addEventListener("keyup", function () {

    if(username.value.length == 0){

        usernameMessage.textContent = "";
        return;
    }

    let xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../includes/controlla_registrazione.php",
        true
    );

    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhr.onload = function () {

        if(this.status == 200){

            let response =
                JSON.parse(this.responseText);

            if(response.username != ""){

                usernameMessage.style.color =
                    "#8b0000";

                usernameMessage.textContent =
                    "Username già utilizzato!";
            }
            else{

                usernameMessage.style.color =
                    "green";

                usernameMessage.textContent =
                    "Username disponibile";
            }
        }
    };

    xhr.send(
        "username=" +
        encodeURIComponent(username.value)
    );
});

/* CONTROLLO EMAIL */
email.addEventListener("keyup", function () {

    if(email.value.length == 0){

        emailMessage.textContent = "";
        return;
    }

    let xhr = new XMLHttpRequest();

    xhr.open(
        "POST",
        "../includes/controlla_registrazione.php",
        true
    );

    xhr.setRequestHeader(
        "Content-type",
        "application/x-www-form-urlencoded"
    );

    xhr.onload = function () {

        if(this.status == 200){

            let response =
                JSON.parse(this.responseText);

            if(response.email != ""){

                emailMessage.style.color =
                    "#8b0000";

                emailMessage.textContent =
                    "Email già registrata!";
            }
            else{

                emailMessage.style.color =
                    "green";

                emailMessage.textContent =
                    "Email disponibile";
            }
        }
    };

    xhr.send(
        "email=" +
        encodeURIComponent(email.value)
    );
});

/* CONTROLLO PASSWORD */
password.addEventListener("keyup", function () {

    let regex =
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

    if(password.value.length == 0){

        passwordMessage.textContent = "";
    }
    else if(!regex.test(password.value)){

        passwordMessage.style.color =
            "#8b0000";

        passwordMessage.textContent =
            "Minimo 8 caratteri, una maiuscola, una minuscola e un numero";
    }
    else{

        passwordMessage.style.color =
            "green";

        passwordMessage.textContent =
            "Password valida";
    }
});