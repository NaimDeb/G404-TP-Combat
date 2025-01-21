<?php

if (!isset($_SESSION["currentHero"])) {
    if (isset($_COOKIE["currentHeroId"])) {
        $heroRepo = new HeroRepository;
        $_SESSION["currentHero"] = $heroRepo->fetchHeroByID($_COOKIE["currentHeroId"]);
    } else {
        header("location: ./index.php");
    }
}

?>