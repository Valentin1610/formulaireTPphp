<?php
// Récupere les Constantes et les regex dans un autre fichier

require './regex.php';
require './constants.php';
$datecurrent = new DateTime();
$datecurrent -> format('Y-m-d');
// On choisit la méthode POST pour récupérer les valeurs du formulaire  

$errors = array();

if($_SERVER["REQUEST_METHOD"] =='POST'){

    // On Filtre et on nettoie le nom

    $lastname = filter_input(INPUT_POST, 'lastname',  FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($lastname)){
        $errors['lastname'] = 'Veuillez entrez obligatoirement un nom ';
    } else{
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP,array('options' => array('regexp' => REGEX_LASTNAME)));
        if(!$isOk){
            $errors['lastname'] = 'Ce nom n\'est pas valide' ;   
        }
    }

    // Vérification de la civilité

    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($gender)){
        if($gender != 1 && $gender !=2){
            $errors['gender'] ='Veuillez obligatoirement choisir votre civilité';
    }
}

    // On filtre , on nettoie, et on valide si c'est un email 

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if(empty($email)){
        $errors['email'] = 'Veuillez obligatoirement entrer un email';
    } else{
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL); 
        if($isOk == false){
            $errors['email'] = 'L\'email n\'est pas bon' ;
        }
    }

    
    // On vérifie si l'utilisateur entre un mot de passe  
    
    $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);
    $passwordverif = filter_input(INPUT_POST,'passwordverif', FILTER_DEFAULT);
    if(empty($password)){
        $errors['password']= 'Veuillez entrez un mot de passe';
    } elseif ($password !== $passwordverif) {
            $errors['password'] = 'Veuillez entrez un mot de passe identique';
        } 
    }
    
    //  vérifie si il a bien choisi un pays de naissance 
    
    $countryBirth = filter_input(INPUT_POST, 'countryBirth');
    if(empty($countryBirth)){
        $errors['countryBirth'] = 'Veuillez obligatoirement entrez un pays de naissance';
    } else{
        if((array_key_exists($countryBirth, COUNTRIES)) == false){
            $errors['countryBirth'] = 'Veuillez sélectionnez votre pays de naissance';
        }
    }

    // On vérifie si il est bien né avant la date d'aujourd'hui


    $dateBirth = filter_input(INPUT_POST, 'dateBirth', FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($dateBirth)){
        $errors['dateBirth'] = 'Veuillez obligatoirement entrez une date de naissance ';
    } else{
        $timedate = new DateTime($dateBirth);
        $timestamp_date = $timedate -> getTimestamp();
        $timestamp_currentdate = $currentdate -> getTimestamp();
        if($timestamp_date > $timestamp_currentdate){
            $errors['datebirth'] = 'Veuillez entrez une date passé';
        }
    }

    
    // On filtre si c'est un nombre on nettoie ensuite on valide si ca correspond bien à un code postal 
    
    $adressCode = filter_input(INPUT_POST,'adressCode', FILTER_SANITIZE_NUMBER_INT);
    if(empty($adressCode)){
    }
    $isOk = filter_var($adressCode, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_ADRESSCODE)));
        if($isOk == false){
            $errors['adressCode'] = 'Le code postal ne correspond pas';
        }

        // Vérification de l'url

    $url = filter_input(INPUT_POST,'url', FILTER_SANITIZE_URL);
    if(empty($url)){
    } else{
        $isOk = filter_var($url , FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => REGEX_URL)));
        if(!$isOk){
            $errors['url'] = 'L\'URL n\'est pas valide';
    }
    }

    // Fin de la vérification de l'URL

    // Vérification des langages utilisés

    $languages = filter_input(INPUT_POST, 'languages', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
    if(!is_null($languages)){
        foreach($languages as $key => $value){
            if(array_key_exists($value, LANGUAGES) == false){
                $errors['languages'] ='Veuillez bien choisir vos langages que vous connaissez';
            }
        }
    }

    //  Fin de la Vérification des langages utilisés

    // Vérification du fichier

    $file = filter_input(INPUT_POST,'file');
    if($file !== null){
        if(file_exists($file)){
        } 
    }

    // Vérification du textarea

    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    if(!empty($description)) {
        if(strlen($description) < 10 || $strlen($description) > 500){
            $errors['description'] = 'Veuillez entrez un messager entre 10 et 500 caractéres';
        }
    }

    // Fin de la vérification du textarea

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/style.css">   
    <script defer src ="public/assets/js/script.js"></script>
    <title>Super Formulaire</title>
</head>
<body>
    
    <!-- La tête de la page -->
    

    <header>
        <h1 class= "text-center p-3">Le super Formulaire</h1>
        <p class ="text-center">Faire un formulaire d'inscription permettant à un utilisateur de saisir les informations suivantes :
        </p>
    </header>

    <!-- Fin de la tête de page -->

    <!-- Début du formulaire -->
    
    <main>
        <fieldset>
            <div class="form_container">
                <form method="post" id="form" novalidate>
                    <h2>Se connecter</h2>

                    <!-- Input du nom -->

                    <div class="input_box">
                        <label for="lastname" class="form-label">Votre nom : *</label>
                        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Entrez votre nom " autocomplete="family-name" required>
                        <div id="nameHelp" class="form-text error d-none">Ce nom n'est pas valide</div>
                    </div>

                    <!-- Fin de l'input du nom -->
                    
                    <!-- Input pour la civilité -->

                    <div class="input_box">
                        <p>Civilité : *</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gender" name="gender" value="1">
                            <label class="form-check-label" for="genderM">M</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gender" name="gender" value="2">
                            <label class="form-check-label" for="genderMme">Mme</label>
                        </div>
                    </div>

                    <!-- Fin de l'input pour la civilité -->

                    <!-- Input pour l'adresse mail -->

                    <div class= "input_box">
                        <label for="email">Votre adresse mail :* </label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="Entrez votre adresse mail" required>
                        <div id="emailHelp" class="form-text error d-none"></div>
                    </div>

                    <!-- Fin de l'input pour l'adresse mail -->

                    <!-- Input du mot de passe et de la vérification du mot de passe -->

                    <div class="input_box">
                        <label for="password">Entrez votre mot de passe :*</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Entrez votre mot de passe" required>
                    </div>
                    <div class="input_box">
                        <input class="form-control" type="password" name="passwordverif" id="passwordverif" placeholder="Confirmez votre mot de passe" required>
                        <div id ="passwordVerifHelp" class="form-text error d-none">Votre mot de passe n'est pas identique </div>
                    </div>

                    <!-- Fin des input mot de passe et vérification de mot de passe  -->

                    <!-- Input de la date et lieu de naissance -->

                    <div class="input_box">
                        <label for="date">Date de naissance et lieu de naissance*</label>
                        <input class="form-control" type= "date" name="datebirth" id="datebirth" max="<?= $datecurrent -> format('Y-m-d')?>" required>
                    </div>
                    <div class="input_box">
                        <select name="countryBirth" id="countryBirth" required>
                            <option disabled selected>-- Sélectionnez votre pays de Naissance --</option>
                            <?php
                            foreach(COUNTRIES as $key => $countries){?>
                            <option value="<?= $key ?>"><?= $countries?></option>
                        <?php } ?> 
                        </select>
                    </div>

                    <!-- Fin de l'input de la date et lieu de naissance -->

                    <!-- Input du code postal -->

                    <div class="input_box">
                        <label for="adressCode">Code Postal : * </label>
                        <input class="form-control" type="text" name="adressCode" id="adressCode" placeholder ="ex : 80200">
                        <div id="adresscodeVerif" class="form-text error d-none">Entrez un code postal valide</div>
                    </div>

                    <!-- Fin de l'input du code postal -->

                    <!-- Input de l'url Linked -->

                    <div class="input_box">
                        <label for="url">Entrez votre URL de votre compte Linked si vous avez un compte :</label>
                        <input class="form-control" type="url" name="url" id="url" placeholder="Url de votre compte Linked ">
                    </div>

                    <!-- Fin de l'input de l'url Linked -->

                    <div>
                        <p>Quels langages web connaissez-vous ?</p>
                        <?php foreach(LANGUAGES as $key => $language){?>
                            <div class="form-check form-check-inline">
                                <input class ="form-check-input" type="checkbox" id="language_<?= $key ?>" name="languages[]" value="<?= $key ?>">
                                <label class ="form-check-label" for="language_<?= $key ?>"><?= $language ?></label>
                            </div>
                        <?php } ?>
                    </div>
                    <div>
                        <input type="file" name="file" id="file">
                    </div> 
                    <div class="input_box form-floatinf">
                        <label for="description">Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir.</label>
                        <textarea class ="form-control" id="description" name="description" cols="30"></textarea>
                    </div>
                    <div>
                        <p>* : correspond à des champs obligatoires.</p>
                    </div>
                    <div class="p-2">
                        <button type="submit" id="submit" name="submit">
                            <span>Envoyez</span>
                        </button>
                    </div>
                </form>
            </div>
        </fieldset>
    </main>

    <!-- Fin du Formulaire -->

    <script src ="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>