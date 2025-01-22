<main class="bg-[url('../image/campfire_bg.png')] bg-cover bg-no-repeat text-white min-h-screen w-full">
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
     * @var Hero $hero
     */
    $hero = $_SESSION["currentHero"];
    ?>







    <section class="flex flex-col items-center mt-8 absolute bottom-[10%] left-[28%]">
        <div class="flex flex-col items-center  gap-2 p-4 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold bg-black bg-opacity-45"><?php echo $hero->getName(); ?></h2>
            <p class="text-lg bg-black font-bold bg-opacity-45">HP: <span id="currentHeroHp"><?php echo $hero->getHealthPoints(); ?></span> / <?php echo $hero->getMaxHealthPoints(); ?></p>
            <img src="<?php echo $hero->getImage_url(); ?>" alt="Hero Image" class="w-32 h-32 rounded-full mb-4">
        </div>
    </section>

    <div class="flex justify-between items-center px-48">
        <button id="healButton"  class="w-32 px-4 py-2 h-12  bg-green-500 text-xl text-white border-none cursor-pointer rounded-md">Heal</button>
        <button id="levelUpButton" class="w-32 px-4 py-2 h-12 mb-16 bg-green-500 text-xl text-white border-none cursor-pointer rounded-md">Level Up</button>
        <button id="continueButton" class="w-32 px-4 py-2 h-12  bg-green-500 text-xl text-white border-none cursor-pointer rounded-md text-nowrap">Continuer -></button>
    </div>

    <!-- Level up form -->

    <script> let stats = []; </script>

    <div id="levelUpForm" class="hidden mt-4 p-4 bg-gray-800 max-w-[400px] m-auto  rounded-lg shadow-lg">
        <?php
        $stats = [
            "str" => "Force",
            "int" => "Intelligence",
            "dex" => "Dextérité",
            "con" => "Constitution"
        ];
        $stat_descriptions = [
            "Force" => "Augmente les dégâts physiques.",
            "Intelligence" => "Renforce les attaques magiques.",
            "Dextérité" => "Améliore l'agilité et la vitesse.",
            "Constitution" => "Augmente les points de vie."
        ];

        foreach ($stats as $id => $name) {
            echo "
            <div class='flex items-center gap-4'>
                <label for='{$id}' class='text-white text-lg w-32 relative group'>
                    {$name}
                    <div class='absolute top-8 left-0 bg-gray-800 text-white text-sm p-2 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity'>
                        {$stat_descriptions[$name]}
                    </div>
                </label>
                <button type='button' class='hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-6 h-6 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', -1)\">
                <svg class='bg-gray-500 group-hover:bg-slate-300 ' width='12' height='2' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                    </button>

                <input type='text' id='{$id}' name='{$id}' value='{$hero->getSingleStat($id)}' class='stat bg-transparent text-white text-center placeholder-gray-500 border-none text-lg focus:outline-none w-20 font-medium' readonly>

                <button type='button' class='hover:bg-gray-500 outline outline-2 outline-gray-500 hover:outline-gray-700 w-6 h-6 flex items-center justify-center rounded-full group' onclick=\"adjustStat('{$id}', 1)\">
                    <svg class='' 
                        width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <rect x='7' y='1' width='2' height='14' class='fill-gray-500 group-hover:fill-slate-300 ' />
                        <rect x='1' y='7' width='14' height='2' class='fill-gray-500 group-hover:fill-slate-300 ' />
                    </svg>
                </button>
            </div>";
            
        }?>


        <!-- Points Restants & Reset button -->
        <div class="text-right text-white text-lg font-semibold flex flex-col gap-4">
            <div id="points-remaining" class="text-center outline outline-1 outline-gray-500 p-2 text-gray-400 rounded-md">
                Points restants a donner <br>
                <!-- todo : points restants -->
                <span id="remaining-points" class="font-bold text-gray-300 text-xl"><?php echo "1" ?></span>
            </div>
            <button type="button" onclick="confirmStatChange()" id="reset-stats" class="px-4 py-2 text-gray-500 bg-transparent outline outline-2 outline-green-500 hover:bg-green-500 hover:text-slate-200 m-auto rounded-full">Confirmer</button>
        </div>
    </div>


    <div id="log" class="text-3xl text-white bg-black bg-opacity-50 absolute bottom-1/2 left-1/2 -translate-x-1/2 w-1/3 h-8 text-center font-bold"></div>



    <script>
        // todo : level up given points
    let remainingPoints;
    let totalGivenPoints = 1



    let totalBaseStats = <?php

    $number = 0;
    $allStats = $hero->getAllStats();
    foreach ($allStats as $statName => $value) {
        $number+= $value;
    }

    echo $number;
    
    ?>


    let baseStats = {
        str: <?php echo $hero->getSingleStat('str'); ?>,
        int: <?php echo $hero->getSingleStat('int'); ?>,
        dex: <?php echo $hero->getSingleStat('dex'); ?>,
        con: <?php echo $hero->getSingleStat('con'); ?>
    };




    // Fix remainingPoints not accounting the current points when refreshing the page
    let remainingPointsDiv = document.querySelector("#remaining-points")
    let currentStats = 0;
    document.querySelectorAll(".stat").forEach(singlestat => {

        currentStats += parseInt(singlestat.value)

    })

    remainingPoints = totalGivenPoints - (currentStats - totalBaseStats)


    remainingPointsDiv.innerHTML = remainingPoints;


    const currentHeroHP = document.getElementById('currentHeroHp');

    



    function adjustStat(statId, delta) {
    const statInput = document.getElementById(statId);
    const currentValue = parseInt(statInput.value, 10);
    const baseValue = baseStats[statId]; // La valeur de base de la stat
    const newValue = currentValue + delta;

    
    

    if (newValue >= baseValue && (remainingPoints > 0 || delta < 0)) {
        statInput.value = newValue;
        remainingPoints -= delta;
        remainingPointsDiv.textContent = remainingPoints;
        statInput.style.fontWeight = newValue >= 20 ? '900' : newValue >= 15 ? '700' : newValue <= 9 ? '100' : '500';
    }
}

    function confirmStatChange(event) {
        // todo : add confirm 
    }




    document.getElementById('levelUpButton').addEventListener('click', function() {
        document.getElementById('levelUpForm').classList.toggle('hidden');
    });


    const healButton = document.getElementById('healButton');
    const continueButton = document.getElementById('continueButton');

    healButton.addEventListener("click", handleHealButton);
    continueButton.addEventListener("click", handleContinueButton);

    async function handleHealButton(){

        // If you bought something from shop, return
        // todo: add shop thing


        // Ajax request to set HP to +50%

        return fetch('prepare_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    "action": "heal"
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                log.textContent = (data.message);
                currentHeroHP.innerHTML = (data.value)
            })
            .catch(error => console.error('Error:', error));
    }

    function handleContinueButton() {
        // go to fight.php for now

        window.location.href = "./fight.php";
    }




    



    </script>
</main>