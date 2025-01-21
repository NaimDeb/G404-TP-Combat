<?php

class FightManager
{

    private Hero $hero;
    private Entity $enemy;


    public function __construct(Entity $hero, Entity $enemy)
    {
        $this->hero = $hero;
        $this->enemy = $enemy;
    }

    public function displayEntity(Entity $entity)
    {
        $entityName = htmlspecialchars($entity->getName());
        $entityLevel = htmlspecialchars($entity->getLevel());
        $entityImage = htmlspecialchars($entity->getImage_url());
        $entityHP = htmlspecialchars($entity->getHealthPoints());
        $entityMaxHP = htmlspecialchars($entity->getMaxHealthPoints());
        $entityHpPercentage = ($entityHP / $entityMaxHP) * 100;
        $entityAttackSpeed = htmlspecialchars($entity->getAttackSpeed());
        $entityAttackDamage = htmlspecialchars($entity->getAttackDamage());
        $entitySkillDamage = htmlspecialchars($entity->getSkillDamage());

        ob_start()
        ?> 
        
        <div id="entity" class="w-[250px] flex flex-col items-center gap-4">
    <!-- Entity Name -->
    <h2 class="text-center text-lg font-semibold"><?= $entityName; ?></h2>
    <!-- Entity Level -->
    <h3 class="text-sm font-bold text-right w-full">LVL <?= $entityLevel; ?></h3>
    <!-- HP Bar -->
    <div class="w-full bg-gray-500 rounded-full h-6 relative flex items-center">
        <!-- HP Bar Fill -->
        <div 
            class="absolute top-0 left-0 rounded-full bg-red-600 shadow-inner shadow-red-900 h-full"
            style="width: <?= $entityHpPercentage; ?>%;"></div>
        <!-- Centered Text -->
        <div class="relative w-full text-center text-white font-bold z-10">
            <span id="entityCurrentHPSpan"><?= $entityHP; ?></span> / <span><?= $entityMaxHP; ?></span>
        </div>
    </div>
    <!-- Entity Image -->
    <img 
        src="<?= $entityImage; ?>" 
        alt="<?= $entityName; ?>" 
        class="max-w-[250px] max-h-[250px] rounded-lg shadow-md">
    <!-- Stats -->
    <div class="text-sm text-center space-y-1">
        <p>Attack Speed: <?= $entityAttackSpeed; ?></p>
        <p>Attack Damage: <?= $entityAttackDamage; ?></p>
        <p>Skill Damage: <?= $entitySkillDamage; ?></p>
    </div>
</div>


        <?php 
        return ob_get_clean();
        
    }


    public function autoFight()
    {

        $texte = '';

        $damage = $this->hero->attack($this->enemy);

        $texte .= "<p class='text-green-400'>{$this->hero->getName()} attaque {$this->enemy->getName()} pour <strong>{$damage}</strong> dégats !</p>";


        if ($this->enemy->getHealthPoints() > 0) {
            
            $damage = $this->enemy->attack($this->hero);

            $texte .=  "<p class='text-red-400'>{$this->enemy->getName()} attaque {$this->hero->getName()} pour <strong>{$damage}</strong> dégats !</p></p>";
        }


        if ($this->hero->getHealthPoints() <= 0) {
            $texte .= "<p>{$this->enemy->getName()} a gagné le combat !</p>";

            // Handle the hero's death to not cheese the game

            $this->hero->dieForever();


        } elseif ($this->enemy->getHealthPoints() <= 0) {
            $texte .= "<p>{$this->hero->getName()} a gagné le combat !</p>";
        }
    
        return $texte;
    }




}
?>
