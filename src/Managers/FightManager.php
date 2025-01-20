<?php

class FightManager
{

    private Entity $hero;
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
        
        <div id='entity' class='w-[250px] flex flex-col gap-2'>
            <h2 class='text-center'><?= $entityName; ?></h2>
            <h3 class='text-sm font-bold text-end'>LVL <?= $entityLevel; ?></h3>
            <div class='hp-bar w-full bg-gray-500 rounded-full'>
            <div class='hp-bar-fill rounded-full text-white font-bold text-center bg-red-600 shadow-inner shadow-red-900 max-w-[250px]' style='width: <?= $entityHpPercentage; ?>%'>
            <div><span id='entityCurrentHPSpan'><?= $entityHP; ?></span> / <span><?= $entityMaxHP; ?></span></div>
            </div>
            </div>
            <img src='<?= $entityImage; ?>' alt='<?= $entityName; ?>' class='max-w-[250px] max-h-[250px]'>
            <p>Attack Speed: <?= $entityAttackSpeed; ?></p>
            <p>Attack Damage: <?= $entityAttackDamage; ?></p>
            <p>Skill Damage: <?= $entitySkillDamage; ?></p>
        </div>

        <?php 
        return ob_get_clean();
        
    }


    public function autoFight()
    {

        $texte = '';

        $damage = $this->hero->attack($this->enemy);

        $texte .= "<p>{$this->hero->getName()} attaque {$this->enemy->getName()} pour <strong>{$damage}</strong> dégats !</p>";


        if ($this->enemy->getHealthPoints() > 0) {
            
            $damage = $this->enemy->attack($this->hero);

            $texte .=  "<p>{$this->enemy->getName()} attaque {$this->hero->getName()} pour <strong>{$damage}</strong> dégats !</p></p>";
        }


        if ($this->hero->getHealthPoints() <= 0) {
            $texte .= "<p>{$this->enemy->getName()} a gagné le combat !</p>";
        } elseif ($this->enemy->getHealthPoints() <= 0) {
            $texte .= "<p>{$this->hero->getName()} a gagné le combat !</p>";
        }
    
        return $texte;
    }

    public function showFinalScreen()
    {
        ob_start();
        ?>
        <div class="final-screen">
            <p>Combat terminé !</p>
            <a href="finalScreen.php" class="btn btn-primary">Voir l'écran final</a>
        </div>
        <?php
        return ob_get_clean();
    }

    public function showNextFightButton()
    {
        ob_start();
        ?>
        <div class="next-fight">
            <p>Préparez-vous pour le prochain combat !</p>
            <button onclick="startNewFight()" class="btn btn-primary">Nouveau Combat</button>
        </div>
        <script>
            function startNewFight() {
                // Logic to start a new fight
                location.reload(); // For simplicity, just reload the page
            }
        </script>
        <?php
        return ob_get_clean();
    }



}
?>
