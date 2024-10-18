function validationEntraineur(e) {
    const cin = document.getElementById("cin").value;
    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const montant = document.getElementById("montant").value;
    const date = document.getElementById("date").value;
    const moisPaye = document.getElementById("moisPaye").value;

    if (cin.length !== 8 || isNaN(cin) || cin === "" || !/^[01][0-9]*$/.test(cin)) {
        alert("CIN doit être composé de 8 chiffres ou commence avec 1 ou 0");
        e.preventDefault(); // Prevent submission if validation fails
        return false;
    }
    if (!/^[A-Za-z]+$/.test(nom) || nom === "") {
        alert("Nom doit étre composé seulement des letters.");
        e.preventDefault();
        return false;
    }
    if (!/^[A-Za-z]+$/.test(prenom) || prenom === "") {
        alert("Prénom doit étre composé seulement des letters.");
        e.preventDefault();
        return false;
    }
    if (isNaN(montant) || montant === "" || montant <= 0) {
        alert("Montant doit étre composé par des chiffres.");
        e.preventDefault();
        return false;
    }
    if (!/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/.test(date) || date === "") {
        alert("Date doit respecter la format YYYY-MM-DD.");
        e.preventDefault();
        return false;
    }
    if (isNaN(moisPaye) || moisPaye === "" || moisPaye <= 0) {
        alert("Mois Payé doit étre un entier.");
        e.preventDefault();
        return false;
    }

    return true; // Allow form submission if all validations pass
}

function validationJoueur(e) {
    const cin = document.getElementById("cin").value;
    const nom = document.getElementById("nom").value;
    const prenom = document.getElementById("prenom").value;
    const montant = document.getElementById("montant").value;
    const date = document.getElementById("date").value;
    const moisPaye = document.getElementById("moisPaye").value;

    if (cin.length !== 8 || isNaN(cin) || cin === "" || !/^[01][0-9]*$/.test(cin)) {
        alert("CIN doit être composé de 8 chiffres ou commence avec 1 ou 0");
        e.preventDefault(); // Prevent submission if validation fails
        return false;
    }
    if (!/^[A-Za-z]+$/.test(nom) || nom === "") {
        alert("Nom doit être composé seulement de lettres.");
        e.preventDefault();
        return false;
    }
    if (!/^[A-Za-z]+$/.test(prenom) || prenom === "") {
        alert("Prénom doit être composé seulement de lettres.");
        e.preventDefault();
        return false;
    }
    if (isNaN(montant) || montant === "" || montant <= 0) {
        alert("Montant doit être un chiffre valide.");
        e.preventDefault();
        return false;
    }
    if (!/^(19|20)\d\d-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/.test(date) || date === "") {
        alert("Date doit respecter le format YYYY-MM-DD.");
        e.preventDefault();
        return false;
    }
    if (isNaN(moisPaye) || moisPaye === "" || moisPaye <= 0) {
        alert("Mois Payé doit être un entier.");
        e.preventDefault();
        return false;
    }

    return true; // Allow form submission if all validations pass
}
