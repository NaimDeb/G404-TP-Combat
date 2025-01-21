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


<main class="min-h-screen py-10 ">



    <!-- todo : Action bar that shows who's getting the turn next -->



    <section class="flex justify-around">

        <!-- Hero -->
        <div id="heroDiv">
            <?php echo $fight->displayEntity($myHero); ?>
        </div>


        <!-- Log -->

        <div id="log" class="bg-opacity-10 bg-black w-[40%] max-h-[400px] text-center flex flex-col gap-3 py-3 overflow-y-scroll overflow-ellipsis scroll-">

            Début du combat !

        </div>


        <!-- Enemy -->
        <div id="enemyDiv">
            <?= $fight->displayEntity($myEnemy); ?>
        </div>


    </section>

    <section id="nextButton" class="m-auto w-1/5 min-h-[200px] "></section>


    <section class="w-full flex justify-between items-center mt-10 fixed bottom-0 px-16 py-4 bg-purple-800 bg-opacity-35" id="actionSection">
        <div class="flex gap-4">
            <button class="btn btn-attack bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Attaquer</button>
            <button class="btn btn-defend bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Défendre</button>
            <button class="btn btn-skill bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Compétences</button>
        </div>
        <div class="inventory outline outline-1 outline-black p-4 rounded-md mt-4">
            <h3 class="text-lg font-bold mb-2">Inventaire</h3>
            <ul id="inventoryList" class="list-none flex gap-4 flex-wrap max-w-1/3 pl-5">
                <!-- Inventory items will be listed here -->
            </ul>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const actionSection = document.getElementById('actionSection');
            const attackButton = document.querySelector('.btn-attack');
            const defendButton = document.querySelector('.btn-defend');
            const skillButton = document.querySelector('.btn-skill');
            const combatLog = document.getElementById('log');
            const inventoryList = document.getElementById('inventoryList');

            attackButton.addEventListener("click", () => performAction('heroAttack'));
            defendButton.addEventListener("click", () => performAction('heroDefend'));
            skillButton.addEventListener("click", () => performAction('heroSkill'));

            function updateEntity(entity) {
                performAction('update', entity)
            }

            async function performAction(action, entity = "hero") {
                return fetch('combat_action.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            "action": action,
                            "entity": entity
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        updateCombatLog(data.message);
                        refreshEntities(data.hero, data.enemy);
                        if (data.gameOver) {
                            updateCombatLog(data.gameOverMessage);
                            showNextButton(data.gameOverHasHeroWon);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }


            function refreshEntities(hero, enemy) {
                document.getElementById('heroDiv').innerHTML = hero;
                document.getElementById('enemyDiv').innerHTML = enemy;
            }


            function showNextButton(hasHeroWon) {
                if (true) {
                    console.log("win");

                    nextButton.innerHTML = `
            <a href="prepareForNextFight.php" class="text-2xl text-white text-center bg-green-700">
            <div class="final-screen bg-green-600 text-white px-4 py-2 w-full text-center">
            Préparez-vous pour le prochain combat !
            </div></a>
        `
                } else {
                    console.log('lose');

                    nextButton.innerHTML = `
            <a href="youAreDead.php" class="text-2xl text-white text-center bg-red-700">
                <div class="final-screen bg-red-600 text-white px-4 py-2 w-full text-center">
                    Vous avez perdu
                </div>
            </a>
            `
                }
            }


            function updateCombatLog(message) {
                const logEntry = document.createElement('div');
                logEntry.innerHTML = message;
                combatLog.appendChild(logEntry);
            }


            // Example inventory items
            const inventoryItems = ["Potion de soin", "Élixir de mana", "Pierre magique"];


            inventoryItems.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                inventoryList.appendChild(li);
            });
        });
    </script>




</main>