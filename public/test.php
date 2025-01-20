<?php

function getAttackDamage() {
    return 100;
}

// Original JavaScript implementation
function calculateTotalDamageJS() {
    $attackDamage = getAttackDamage();
    $randomFactor = (mt_rand() / mt_getrandmax()) * (1.5 - 0.75) + 0.75;
    $modifiedFactor = pow($randomFactor - 0.75, 1.5) + 0.75;
    $totalDamage = ceil(($attackDamage / 10) * $modifiedFactor);
    return $totalDamage;
}

// PHP version
function calculateTotalDamagePHP() {
    $attackDamage = getAttackDamage();
    $randomFactor = (mt_rand() / mt_getrandmax()) * (1.5 - 0.75) + 0.75;
    $modifiedFactor = pow($randomFactor - 0.75, 1.5) + 0.75;
    $totalDamage = ceil(($attackDamage / 10) * $modifiedFactor);
    return $totalDamage;
}

// Test comparison
for ($i = 0; $i < 10; $i++) {
    $jsDamage = calculateTotalDamageJS();
    $phpDamage = calculateTotalDamagePHP();

    echo "Iteration $i:\n";
    echo "<br>";
    echo "JS Damage: $jsDamage\n";
    echo "<br>";

    echo "PHP Damage: $phpDamage\n";
    echo "<br>";

    echo str_repeat("-", 20) . "\n";
}
