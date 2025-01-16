<?php
include "../utils/autoloader.php";

var_dump($_FILES);

$sanitizedData = HeroService::verifyHeroData($_POST, $_FILES);

var_dump($sanitizedData);
die();




$myRepository = new HeroRepository;


?>