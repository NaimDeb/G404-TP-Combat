<?php
include_once "../utils/autoloader.php";

session_start();

if ( !isset($_SESSION["currentHero"]) || !isset($_POST)) {
    echo json_encode(['message' => 'Combat session not initialized.']);
    exit;
}

$hero = $_SESSION["currentHero"];


$input = $_POST;
$action = $input['action'] ?? '';
$entity = $input['entity'] ?? '';

$response = ['message' => ''];

switch ($action) {
    case 'heal':
        $currentHealth = $hero->getHealthPoints();
        $maxHealth = $hero->getMaxHealthPoints();
        $hero->setHealthPoints(min(($currentHealth + ($maxHealth * 0.5)), $maxHealth));

        $nbOfHealthHealed = $hero->getHealthPoints() - $currentHealth;

        $response['message'] = "Vous avez été soigné de " . $nbOfHealthHealed . " points de vie.";
        $response['value'] = $hero->getHealthPoints();
        break;
    default:
        $response['message'] = "Invalid action.";
        break;
}


echo json_encode($response);
?>