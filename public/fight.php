<?php
include_once "./assets/components/htmlstart.php";

if (!isset($_SESSION["currentHero"])){
    if (isset($_COOKIE["currentHeroId"])) {
        $heroRepo = new HeroRepository;
        $_SESSION["currentHero"] = $heroRepo -> fetchHeroByID($_COOKIE["currentHeroId"]);
    } else {
        header("location: ./index.php");
    }
}
$myHero = $_SESSION["currentHero"]->updateSecondaryStats();

?>


<!-- Main Content -->
<main class="min-h-screen py-10 ">

<section class="flex justify-around">
    <!-- Hero -->
    <div id="hero" class="w-[250px] flex flex-col gap-2">
        <?php
        // First initialization
        $heroName = $myHero->getName();
        $heroLevel = $myHero->getLevel();
        $heroImage = $myHero->getImage_url();
        $heroHP = $myHero->getHealthPoints();
        $heroMaxHP = $myHero->getMaxHealthPoints();
        $hpPercentage = ($heroHP / $heroMaxHP) * 100;
        $heroAttackSpeed = $myHero->getAttackSpeed();
        $heroAttackDamage = $myHero->getAttackDamage();
        $heroSkillDamage = $myHero->getSkillDamage();
        ?>

        <h2 class="text-center"><?php echo htmlspecialchars($heroName); ?></h2>
        <h3 class="text-sm font-bold text-end">LVL <?php echo htmlspecialchars($heroLevel); ?></h3>
        <div class="hp-bar w-full bg-gray-500 rounded-full">
            <div class="hp-bar-fill rounded-full text-white font-bold text-center bg-green-600 shadow-inner shadow-green-900" style="width: <?php echo $hpPercentage; ?>%">
            <span id="heroCurrentHPSpan"><?php echo htmlspecialchars($heroHP); ?></span> / <span><?php echo htmlspecialchars($heroMaxHP); ?></span>
            </div>
        </div>
        <img src="<?php echo htmlspecialchars($heroImage); ?>" alt="Hero Image" class="max-w-[250px] max-h-[250px]">

    </div>

    <!-- Text -->
    <div id="log" class="bg-opacity-10 bg-black w-[40%] max-h-[400px] text-center flex flex-col gap-3 py-3 overflow-y-scroll overflow-ellipsis scroll-">

    </div>

    <!-- Enemy -->
    <div id="enemy">
        <?php
        $enemyName = "Enemy de fou de malade";
        $enemyLevel = 1;
        $enemyImage = $myHero->getImage_url();
        $enemyHP = 100;
        $enemyMaxHP = 100;
        $enemyHpPercentage = ($enemyHP / $enemyMaxHP) * 100;
        ?>

        <div id="enemy" class="w-[250px] flex flex-col gap-2">
            <h2 class="text-center"><?php echo htmlspecialchars($enemyName); ?></h2>
            <h3 class="text-sm font-bold text-end">LVL <?php echo htmlspecialchars($enemyLevel); ?></h3>
            <div class="hp-bar w-full bg-gray-500 rounded-full">
                <div class="hp-bar-fill rounded-full text-white font-bold text-center bg-red-600 shadow-inner shadow-red-900" style="width: <?php echo $enemyHpPercentage; ?>%">
                    <div><span id="enemyCurrentHPSpan"><?php echo htmlspecialchars($enemyHP); ?></span> / <span><?php echo htmlspecialchars($enemyMaxHP); ?></span></div>
                </div>
            </div>
            <img src="<?php echo htmlspecialchars($enemyImage); ?>" alt="Enemy Image" class="max-w-[250px] max-h-[250px] invert">
        </div>

    </div>
</section>

<!-- compétences -->
    <section id="competences" class="w-full bg-[#290f52] px-16 py-8 fixed bottom-0">
    <div class="w-full flex justify-between flex-wrap items-center mt-4">
        <div class="flex flex-wrap gap-2 w-1/3">
            <button id="btnAttack" class="bg-blue-500 text-white py-2 px-4 rounded basis-[40%]">Attack</button>
            <button id="btnDefend" class="bg-blue-500 text-white py-2 px-4 rounded basis-[40%]">Defend</button>
            <button id="btnSpecial" class="bg-blue-500 text-white py-2 px-4 rounded basis-[40%]">Special</button>
            <button id="btnRun" class="bg-blue-500 text-white py-2 px-4 rounded basis-[40%]">Run</button>
        </div>
        <div class="flex gap-2 flex-nowrap">
            <button class="bg-yellow-500 text-white py-1 px-2 rounded">Potion</button>
            <button class="bg-yellow-500 text-white py-1 px-2 rounded">Elixir</button>
            <button class="bg-yellow-500 text-white py-1 px-2 rounded">Revive</button>
        </div>
    </div>

</section>

</main>

<script>

    // Hero variables
    const heroName = "<?php echo htmlspecialchars($heroName); ?>";
    const heroLevel = <?php echo htmlspecialchars($heroLevel); ?>;
    const heroImage = "<?php echo htmlspecialchars($heroImage); ?>";
    let heroHP = <?php echo htmlspecialchars($heroHP); ?>;
    let heroMaxHP = <?php echo htmlspecialchars($heroMaxHP); ?>;
    let hpPercentage = <?php echo htmlspecialchars($hpPercentage); ?>;
    let heroAttackSpeed = <?php echo htmlspecialchars($heroAttackSpeed); ?>;
    let heroAttackDamage = <?php echo htmlspecialchars($heroAttackDamage); ?>;
    let heroSkillDamage = <?php echo htmlspecialchars($heroSkillDamage); ?>;

    // Enemy variables
    let enemyName = "<?php echo htmlspecialchars($enemyName); ?>";
    let enemyLevel = <?php echo htmlspecialchars($enemyLevel); ?>;
    let enemyImage = "<?php echo htmlspecialchars($enemyImage); ?>";
    let enemyHP = <?php echo htmlspecialchars($enemyHP); ?>;
    let enemyMaxHP = <?php echo htmlspecialchars($enemyMaxHP); ?>;
    let enemyHpPercentage = <?php echo htmlspecialchars($enemyHpPercentage); ?>;

    // DOM elements
    const heroDiv = document.getElementById('hero');
    const heroHpBarFill = heroDiv.querySelector('.hp-bar-fill');
    const heroHpValue = heroHpBarFill.querySelector("#heroCurrentHPSpan");

    const enemyDiv = document.getElementById('enemy');
    const enemyHpBarFill = enemyDiv.querySelector('.hp-bar-fill');
    const enemyHpValue = enemyHpBarFill.querySelector("#enemyCurrentHPSpan");

    const logDiv = document.getElementById('log');

    // Action buttons
    const attackButton = document.querySelector('#btnAttack');
    const defendButton = document.querySelector('#btnDefend');
    const specialButton = document.querySelector('#btnSpecial');
    const runButton = document.querySelector('#btnRun');

    // Item buttons
    // const potionButton = document.querySelector('button:contains("Potion")');
    // const elixirButton = document.querySelector('button:contains("Elixir")');
    // const reviveButton = document.querySelector('button:contains("Revive")');

    attackButton.addEventListener("click", handleHeroAttack);

    function handleHeroAttack() {
        console.log("Attacking");

        attackDamage = Math.ceil((heroAttackDamage / 10) * (Math.pow((Math.random() * (1.5 - 0.75) + 0.75) - 0.75, 1.5) + 0.75))
        
        
        enemyHP = Math.max(0, enemyHP - attackDamage);

        enemyHpValue.textContent = enemyHP

        logAction(heroName + " attacks for " + attackDamage + " damage");

        enemyHpPercentage = Math.max(0,(enemyHP / enemyMaxHP) * 100);

        
        enemyHpBarFill.style.width = Math.max(0, enemyHpPercentage) + "%";
        
        // Si l'ennemi est vaincu
        if(enemyHpPercentage == 0) {
            logAction(enemyName + " has been vanquished !");
        }

    }

    function logAction(actionString){
        const actionLog = document.createElement('span');
        actionLog.textContent = actionString;
        logDiv.appendChild(actionLog);
    }







</script>


<?php
include_once "./assets/components/htmlend.php";
?>