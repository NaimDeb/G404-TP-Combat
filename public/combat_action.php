<?php
include_once "../utils/autoloader.php";

session_start();

if ( !isset($_SESSION["currentHero"]) || !isset($_SESSION["currentEnemy"]) || !isset($_POST["action"]) || !isset($_POST["entity"]) ) {
    echo json_encode(['message' => 'Combat session not initialized.']);
    exit;
}

$hero = $_SESSION["currentHero"];
$enemy = $_SESSION["currentEnemy"];


$fight = new FightManager($hero, $enemy);


$input = $_POST;
$action = $input['action'] ?? '';
$entity = $input['entity'] ?? '';

$response = ['message' => ''];

switch ($action) {
    case 'heroAttack':
        $damage = $hero->attack($enemy);
        $response['message'] = "<span style='color: green;'>{$hero->getName()} attaque {$enemy->getName()} pour $damage dégats !</span>";
        break;
    case 'heroDefend':
        // Implement hero defend logic
        $response['message'] = "<span style='color: green;'>{$hero->getName()} se défend !</span>";
        break;
    case 'enemyAttack':
        $damage = $enemy->attack($hero);
        $response['message'] = "<span style='color: red;'>{$enemy->getName()} attaque {$hero->getName()} pour $damage dégats !</span>";
        break;
    case 'enemyDefend':
        // Implement enemy defend logic
        $response['message'] = "<span style='color: red;'>{$enemy->getName()} se défend !</span>";
        break;
    case 'heroUseItem':
        // Implement hero use item logic
        $response['message'] = "<span style='color: green;'>{$hero->getName()} utilise un objet !</span>";
        break;
    default:
        $response['message'] = "Invalid action.";
        break;
}

$response['hero'] = $fight->displayEntity($hero);
$response['enemy'] = $fight->displayEntity($enemy);

if ($enemy->getHealthPoints() <= 0) {
    $response['gameOver'] = true;
    $response['gameOverHasHeroWon'] = true;
    $response['gameOverMessage'] = "Vous avez terrassé l'ennemi !";
    unset($_SESSION["currentEnemy"]);
} elseif ($hero->getHealthPoints() <= 0) {
    $response['gameOver'] = true;
    $response['gameOverHasHeroWon'] = false;
    $hero->dieForever();
    $response['gameOverMessage'] = "L'ennemi vous a battu !";
}

echo json_encode($response);
?>