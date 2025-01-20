<?php
include_once "./assets/components/htmlstart.php";
include_once "../utils/autoloader.php";

if (!isset($_SESSION["currentHero"])) {
    if (isset($_COOKIE["currentHeroId"])) {
        $heroRepo = new HeroRepository;
        $_SESSION["currentHero"] = $heroRepo->fetchHeroByID($_COOKIE["currentHeroId"]);
    } else {
        header("location: ./index.php");
    }
}
/**
 * @var Hero $myHero 
 */
$myHero = $_SESSION["currentHero"]->updateSecondaryStats();

/**
 * @var Monster $myEnemy 
 */
$myEnemy = new Monster("Enemi de fou malade");
$myEnemy->updateSecondaryStats();




$fight = new FightManager($myHero, $myEnemy);

?>


<main class="min-h-screen py-10 ">
    <section class="flex justify-around">

        <?php

        $battleText = '';
        while ($myHero->getHealthPoints() > 0 && $myEnemy->getHealthPoints() > 0) {
            $battleText .= $fight->autoFight();
        }


        


        ?>



        <!-- Hero -->
        <div id="heroDiv">
            <?php echo $fight->displayEntity($myHero); ?>
        </div>


        <!-- Log -->

        <div id="log" class="bg-opacity-10 bg-black w-[40%] max-h-[400px] text-center flex flex-col gap-3 py-3 overflow-y-scroll overflow-ellipsis scroll-">

            <?= $battleText; ?>

        </div>


        <!-- Enemy -->
        <div id="enemyDiv">
            <?= $fight->displayEntity($myEnemy); ?>
        </div>


    </section>

    <div id="nextButton" class="m-auto bg-yellow-400 rounded px-4 py-2 ">aaaa</div>





</main>