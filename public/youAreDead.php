<?php
include_once "./assets/components/htmlstart.php";
include_once "../utils/autoloader.php";

if (!isset($_SESSION["currentHero"])) {
    if (isset($_COOKIE["currentHeroId"])) {
        $heroRepo = new HeroRepository;
        $_SESSION["currentHero"] = $heroRepo->fetchHeroByID($_COOKIE["currentHeroId"]);
    } else {

        var_dump("ya po");
        die();
        header("location: ./index.php");
    }
}


/**
 * @var Hero $myHero 
 */
$myHero = $_SESSION["currentHero"];
unset($_SESSION["currentHero"]);
unset($_COOKIE["currentHeroId"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto p-4">
        <div class="max-w-sm mx-auto bg-gray-800 p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-4">Hero Stats</h1>
            <ul>
                <li><strong>Name:</strong> <?php echo htmlspecialchars($myHero->getName()); ?></li>
                <li><strong>Level:</strong> <?php echo htmlspecialchars($myHero->getLevel()); ?></li>
                <li><strong>HP total:</strong> <?php echo htmlspecialchars($myHero->getMaxHealthPoints()); ?></li>
                <li><img src="<?php echo htmlspecialchars($myHero->getImage_url()); ?>" alt="Hero Image" class="w-32 h-32 object-cover rounded-full mx-auto"></li>
            </ul>
            <h2 class="text-xl font-bold mt-4 mb-2">All Stats</h2>
            <ul>
                <?php foreach ($myHero->getAllStats() as $statName => $statValue): ?>
                    <li><strong><?php echo htmlspecialchars($statName); ?>:</strong> <?php echo htmlspecialchars($statValue); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="container mx-auto p-4 text-center">
        <a href="index.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Try again
        </a>
    </div>
</body>
<?php
include_once "./assets/components/htmlend.php";
?>


</html>