// Sélectionne les champs de mot de passe
let pass = document.getElementById("pass");
let pass2 = document.getElementById("cpass");

// Affiche ou masque les mots de passe dans les champs "pass" et "cpass"
function showPassword() {
    if (pass.type === "password" || pass2.type === "password") {
        pass.type = "text";
        pass2.type = "text";
    } else {
        pass.type = "password";
        pass2.type = "password";
    }
}

// Affiche ou masque le mot de passe uniquement dans le champ "pass"
function showLoginPassword() {
    if (pass.type === "password") {
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}
