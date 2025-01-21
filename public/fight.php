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




$fight = new FightManager($myHero, $myEnemy);

?>


<main class="min-h-screen py-10 ">
    <section class="flex justify-around">

        <?php

        $battleText = 'Début du combat ! <br>';

        while ($myHero->getHealthPoints() > 0 && $myEnemy->getHealthPoints() > 0) {
            $battleText .= $fight->autoFight();
        }

        // On garde le vainqueur
        if ($myHero->getHealthPoints() <= 0) {
            $isHeroWin = false;
        } elseif ($myEnemy->getHealthPoints() <= 0) {
            $isHeroWin = true;
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

    <section id="nextButton" class="m-auto w-1/5 min-h-[200px] "></section>


    <script>
        const nextButton = document.getElementById('nextButton');
        const heroDiv = document.getElementById('heroDiv');
        const enemyDiv = document.getElementById('enemyDiv');
        const logDiv = document.getElementById('log');


        logDiv.innerHTML = `<?php echo $battleText; ?>`

        enemyDiv.innerHTML = `<?php echo $fight->displayEntity($myEnemy) ?>`;
        heroDiv.innerHTML = `<?php echo $fight->displayEntity($myHero) ?>`;




        if (<?php echo json_encode($isHeroWin) ?> == true) {
            console.log("win");
            
            nextButton.innerHTML = `
            <div class="final-screen bg-green-700 text-white px-4 py-2 w-full">
            <p>Préparez-vous pour le prochain combat !</p>
            <button onclick="startNewFight()" class="btn btn-primary">Nouveau Combat</button>
            </div>
        `
        } else {
            console.log('lose');
            
            nextButton.innerHTML = `
            <p class='text-2xl text-white text-center'>Vous avez perdu</p>
            <br>
            <div class="final-screen bg-red-600 text-white px-4 py-2 w-full text-center">
            <a href="youAreDead.php" class="btn btn-primary rounded-md">Voir l'écran final</a>
            </div>`
        }

        function startNewFight() {
            // rafraichit juste la page pour l'instant
            location.reload();
        }
    </script>


<?php
include_once "./assets/components/htmlend.php";
?>


</main>