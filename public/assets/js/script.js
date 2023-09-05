
// On récupére les id des Input, les div des messages d'erreur et le btn

let lastname = document.querySelector('#lastname');
let nameHelp = document.querySelector('#nameHelp');
let emailHelp = document.querySelector('#emailHelp');
let email = document.querySelector('#email');
let password = document.querySelector('#password');
let password2 = document.querySelector('#passwordverif');
let passWord2VerifHelp = document.querySelector('#passwordVerifHelp');
let adressCode = document.querySelector('#adressCode');
let adressCodeVerif = document.querySelector('#adresscodeVerif');
let form = document.querySelector('#form');

// Regex Nom

const regexName = /^[a-zA-Z]+$/;

// Regex Adresse Mail 

const regexEmail = /^[(\w\d\W)+]+@[\w+]+\.[\w+]+$/;

// Regex Code Postal

const regexAdressCode = /^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/;

// Fonction récupérer le nom

const checkName = () => {
    lastname.classList.remove('is-invalid','is-valid');
    nameHelp.classList.add('d-none');

    if(lastname.value === ""){
        return
    } 

    let resultlastname = regexName.test(lastname.value);

    if(!resultlastname){
        lastname.classList.add('is-invalid');
        nameHelp.classList.remove('d-none', 'txt-danger');
    } else{
        lastname.classList.add('is-valid')
        nameHelp.classList.add('d-none');
    }
}

// Fonction récupérer l'adresse mail

const checkEmail = () => {
    email.classList.remove('is-invalid', 'is-valid');
    emailHelp.classList.add('d-none');

    if(email.value === ""){
        return
    }

    let resultMail = regexEmail.test(email.value);

    if(!resultMail){
        email.classList.add('is-invalid');
        emailHelp.classList.remove('d-none');
    }else{
        email.classList.add('is-valid');
        emailHelp.classList.add('d-none')
    }
}

//  Création d'une fonction de vérification du password

const checkPassWord = () => {
    password.classList.remove('is-invalid', 'is-valid', 'border-3')
    password2.classList.remove('is-invalid', 'is-valid','border-3')
    passWord2VerifHelp.classList.add('d-none');


    if(password.value == password2.value && password.value != ''){
        passWord2VerifHelp.innerHTML = 'Les mots ne sont pas identiques';
    } else{
        passWord2VerifHelp.innerHTML = '';
    }
    if(password.value != password2.value){
        password.classList.add('is-invalid','border-3');
        password2.classList.add('is-invalid', 'border-3');
        passWord2VerifHelp.classList.remove('d-none');
    } else{
        password.classList.add('is-valid','border-3');
        password2.classList.add('is-valid', 'border-3');
        passWord2VerifHelp.classList.add('d-none');
    }
} 

const checkForm = (event) => {
    event.preventDefault();
    if(password.value == password2.value && password.value != ''){
        form.submit();
    } else {
        passWord2VerifHelp.innerHTML = 'Les mots ne sont pas identiques';
    }
}
// Création d'un fonction pour vérifier le code postal

const checkAdressCode = () => {
    adressCode.classList.remove('is-invalid', 'is-valid', 'border-3');
    adressCodeVerif.classList.remove('d-none');

    if(adressCode.value == '') {
        return;
    }
    let resultAdressCode = regexAdressCode.test(adressCode.value);

    if(!resultAdressCode){
        adressCode.classList.add('is-invalid', 'border-3');
        adressCodeVerif.classList.remove('d-none');
    } else{
        adressCode.classList.add('is-valid','border-3');
        adressCodeVerif.classList.add('d-none');
    }
}


// Tous les écouteurs d'événement

lastname.addEventListener("input", checkName);
email.addEventListener("input", checkEmail);
password.addEventListener("change", checkPassWord);
password2.addEventListener("keyup", checkPassWord);
adressCode.addEventListener("input",checkAdressCode);
form.addEventListener("submit", checkForm);