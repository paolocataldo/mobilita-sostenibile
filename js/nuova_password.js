window.addEventListener("DOMContentLoaded", function () {

    const password =
        document.getElementById("password");

    const confermaPassword =
        document.getElementById("conferma_password");

    const passwordMessage =
        document.getElementById("password_message");

    const confermaPasswordMessage =
        document.getElementById("conferma_password_message");

    /* VALIDAZIONE PASSWORD LIVE */
    password.addEventListener("input", function () {

        let regex =
            /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

        if(password.value.length === 0){

            passwordMessage.textContent = "";

        }
        else if(!regex.test(password.value)){

            passwordMessage.style.color = "#8b0000";

            passwordMessage.textContent =
                "Minimo 8 caratteri, una maiuscola, una minuscola e un numero";

        }
        else{

            passwordMessage.style.color = "green";

            passwordMessage.textContent =
                "Password valida";
        }

        controllaConfermaPassword();
    });

    /* CONTROLLO CONFERMA PASSWORD */
    confermaPassword.addEventListener("input", controllaConfermaPassword);

    function controllaConfermaPassword(){

        if(confermaPassword.value.length === 0){

            confermaPasswordMessage.textContent = "";
            return;
        }

        if(password.value !== confermaPassword.value){

            confermaPasswordMessage.style.color = "#8b0000";

            confermaPasswordMessage.textContent =
                "Le password non coincidono";
        }
        else{

            confermaPasswordMessage.style.color = "green";

            confermaPasswordMessage.textContent =
                "Le password coincidono";
        }
    }

});

/* VALIDAZIONE SUBMIT */
function nuovaPassword(){

    let password =
        document.getElementById("password").value;

    let confermaPassword =
        document.getElementById("conferma_password").value;

    let regex =
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

    if(!regex.test(password)){

        alert(
            "La password non rispetta i requisiti richiesti"
        );

        return false;
    }

    if(password !== confermaPassword){

        alert("Le password non coincidono!");

        return false;
    }

    return true;
}