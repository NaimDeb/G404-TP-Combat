<?php
include "../utils/autoloader.php";

$validator = new ValidatorService();

$validator->checkMethods('POST');


// ! Validation données POST

// hero_name', 'str', 'int', 'dex', 'con
// hero_name
$validator->addStrategy("hero_name", new RequiredValidator);
$validator->addStrategy("hero_name", new StringValidator(50));

// str
$validator->addStrategy("str", new RequiredValidator);
$validator->addStrategy("str", new IntegerValidator(99));
// int
$validator->addStrategy("int", new RequiredValidator);
$validator->addStrategy("int", new IntegerValidator(99));
// dex
$validator->addStrategy("dex", new RequiredValidator);
$validator->addStrategy("dex", new IntegerValidator(99));
// con
$validator->addStrategy("con", new RequiredValidator);
$validator->addStrategy("con", new IntegerValidator(99));;


if (!$validator->validate($_POST)) {

    header('location: ../public/createYourHero.php?error=1');
    return;
}

$sanitizedPOST = $validator->sanitize($_POST);


// A changer
$attributes = ['str', 'int', 'dex', 'con'];
$total = 0;

// Vérifier si les attributs ne sont pas énormes et secs
foreach ($attributes as $attribute) {

    $total += $sanitizedPOST[$attribute];
}

if ($total > 50) {
    header('location: ../public/createYourHero.php?error=cheater');
    return;
}




// ! Validation données FILES



// hero_image
if (isset($_FILES) && $_FILES['hero_image']['error'] === UPLOAD_ERR_OK) {



    $validator->addStrategy("hero_image", new ImageFileValidator);


    if (!$validator->validate($_FILES)) {

        header('location: ../public/createYourHero.php?error=2');
        return;
    }



    // ! On envoie le fichier dans le bon dossier

    $file = $_FILES["hero_image"];
    $uploadDir = '../public/assets/image/Heroes/';

    $fileName = uniqid() . basename($file['name']);

    $uploadPath = $uploadDir . $fileName;


    move_uploaded_file($file['tmp_name'], $uploadPath);

    // On récupère le filename et on le met l'array final
    $sanitizedPOST["filename"] = $fileName;
};

// // On crée l'utilisateur
$myRepository = new HeroRepository;

$hero = $myRepository->createHero($sanitizedPOST);


$_COOKIE["currentHero"] = $hero;

header('location: ../public/index.php');
