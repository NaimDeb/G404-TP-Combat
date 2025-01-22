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
        <h2 class="text-2xl font-bold bg-white bg-opacity-45"><?php echo $hero->getName(); ?></h2>
        <p class="text-lg bg-white bg-opacity-45">HP: <?php echo $hero->getHealthPoints(); ?></p>
        <img src="<?php echo $hero->getImage_url(); ?>" alt="Hero Image" class="w-32 h-32 rounded-full mb-4">
    </div>
</section>

<div class="flex justify-between items-center px-48">
    <button class="w-32 px-4 py-2 h-12  bg-green-500 text-white border-none cursor-pointer rounded-md">Heal</button>
    <button class="w-32 px-4 py-2 h-12 mb-16 bg-green-500 text-white border-none cursor-pointer rounded-md" onclick="document.getElementById('levelUpForm').classList.toggle('hidden')">Level Up</button>
    <button class="w-32 px-4 py-2 h-12  bg-green-500 text-white border-none cursor-pointer rounded-md">Continuer -></button>
</div>

<div id="levelUpForm" class="hidden mt-4 p-4 bg-gray-800 rounded-lg shadow-lg">
    <form action="levelUp.php" method="POST" class="flex flex-col space-y-4">
        <div>
            <label for="str" class="block text-white">Str:</label>
            <input type="number" id="str" name="str" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>
        <div>
            <label for="int" class="block text-white">Int:</label>
            <input type="number" id="int" name="int" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>
        <div>
            <label for="dex" class="block text-white">Dex:</label>
            <input type="number" id="dex" name="dex" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>
        <div>
            <label for="con" class="block text-white">Con:</label>
            <input type="number" id="con" name="con" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
</div>