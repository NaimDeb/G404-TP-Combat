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
$myEnemy = $myEnemy->updateSecondaryStats();
$_SESSION["currentEnemy"] = $myEnemy;




$fight = new FightManager($myHero, $myEnemy);

?>


<main class="h-screen py-10">



    <!-- todo : Action bar that shows who's getting the turn next -->


    <!-- Bouton start fight -->





    <section class="flex justify-around px-16">
    <!-- Hero -->
    <div id="heroDiv">
        <?php echo $fight->displayEntity($myHero); ?>
    </div>

    <!-- Log -->
    <section id="middle" class="flex flex-col w-full justify-between basis-1/3">
        <div id="btnStartFight" class="bg-green-400 text-white px-4 py-2 text-center w-fit mx-auto">
            Commencer le combat
        </div>

        <div id="log" class="bg-opacity-10 bg-black w-full text-center flex flex-col gap-8 py-3 overflow-y-auto overflow-ellipsis basis-1/2 my-8  h-[500px] max-h-[500px] scrollbar-hide">
            <!-- Log items will be added here -->
        </div>

        <div id="turnDiv" class="text-3xl text-white m-auto"></div>

        <section id="progress-bar" class="relative h-6 bg-gray-400 rounded-lg my-4 w-1/2 mx-auto">
            <!-- Barre de progression du héros -->
            <div class="absolute top-0 left-0 w-full h-full flex items-center">
                <!-- Barre verte -->
                <div id="heroBar" class="h-full bg-green-500 z-20 rounded-s-md" style="width: 0%;"></div>
                <!-- Marqueur blanc -->
                <div id="heroMarker" class="absolute h-full w-[3px] bg-white bottom-0 z-20" style="left: 0%"></div>
                <!-- Image du héros -->
                <img id="heroProgress"
                    style="left: 0%"
                    class="absolute bottom-[calc(100%+5px)] transform -translate-x-1/2 max-h-[25px] max-w-[25px] z-10"
                    src="<?= $myHero->getImage_url() ?>"
                    alt="Hero">
            </div>

            <!-- Barre de progression de l'ennemi -->
            <div class="absolute top-0 left-0 w-full h-full flex items-center">
                <!-- Barre rouge -->
                <div id="enemyBar" class="h-full bg-red-500 rounded-s-md" style="width: 0%;"></div>
                <!-- Marqueur blanc -->
                <div id="enemyMarker" class="absolute h-full w-[3px] bg-white bottom-0" style="left: 0%"></div>
                <!-- Image de l'ennemi -->
                <img id="enemyProgress"
                    style="left: 0%"
                    class="absolute bottom-[calc(100%+5px)] transform -translate-x-1/2 max-h-[25px] max-w-[25px] z-0"
                    src="<?= $myEnemy->getImage_url() ?>"
                    alt="Enemy">
            </div>
        </section>
    </section>

    <!-- Enemy -->
    <div id="enemyDiv">
        <?= $fight->displayEntity($myEnemy); ?>
    </div>
</section>

    <section id="nextButton" class="m-auto w-1/5 min-h-[200px] "></section>


    <section class="w-full flex justify-between items-center mt-10 fixed bottom-0 px-16 py-4 bg- bg-opacity-35" id="actionSection">
        <!-- <div class="inventory outline outline-1 outline-black p-4 rounded-md mt-4">
            <h3 class="text-lg font-bold mb-2">Inventaire</h3>
            <ul id="inventoryList" class="list-none flex gap-4 flex-wrap max-w-1/3 pl-5"> -->
                <!-- Inventory items will be listed here
            </ul>
        </div> -->
        <!-- <div class="flex gap-4"> -->
            <button class="btn btn-attack text-2xl bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded m-auto mb-16">Attaquer</button>
            <!-- <button class="btn btn-defend bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Défendre</button> -->
            <!-- <button class="btn btn-skill bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Compétences</button> -->
        <!-- </div> -->
    </section>




    <!-- SCRIPT -->


    <script>
        heroAttackSpeed = <?php echo $myHero->getAttackSpeed() ?>;
        enemyAttackSpeed = <?php echo $myEnemy->getAttackSpeed() ?>;
    </script>

    <script type="module" src="./assets/scripts/fight.js" defer></script>





</main>