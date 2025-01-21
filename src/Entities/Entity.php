<?php

abstract class Entity {


    protected string $name;
    protected string $image_url;
    protected array $stats;
    protected int $level;
    protected bool $isDead;

    protected int $maxHealthPoints;
    protected int $healthPoints;

    protected int $attackSpeed;
    protected int $attackDamage;
    protected int $skillDamage;
    
    
    public function __construct(string $name, bool $isDead)
    {
        $this->name = $name;

        $this->stats = [
            "str" => 10,
            "int" => 10,
            "dex" => 10,
            "con" => 10,
        ];

        $this->level = 1;

        // todo: Calculate health points
        $this->maxHealthPoints = 100;
        $this->healthPoints = $this->maxHealthPoints;

        $this->isDead = $isDead;


    }

    public function attack($target): int{

        // todo : defense
        // todo : crit
        // Attack Damage with a variation between x0.75 to x1.5 with a preference near of a multiplier near 1
        $totalDamage = ceil(($this->getAttackDamage()) * (pow((mt_rand() / mt_getrandmax() * (1.5 - 0.75) + 0.75) - 0.75, 1.5) + 0.75));

        $targetHealth = max(0, ($target->getHealthPoints() - $totalDamage));

        $target->setHealthPoints($targetHealth); 

        return $totalDamage;

    }

    /**
     * Get the value of healthPoints
     */ 
    public function getHealthPoints()
    {
        return $this->healthPoints;
    }

    /**
     * Set the value of healthPoints
     *
     * @return  self
     */ 
    public function setHealthPoints($healthPoints)
    {
        $this->healthPoints = $healthPoints;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of image_url
     */ 
    public function getImage_url()
    {
        return $this->image_url;
    }

    /**
     * Get the value of stats
     */ 
    public function getAllStats()
    {
        return $this->stats;
    }

    /**
     * Get the value of a single stat
     */ 
    public function getSingleStat(string $statName)
    {
        if (!isset($this->stats[$statName])) {
            return null;
        }


        return $this->stats[$statName];
    }

    /**
     * Set the value of stats
     *
     * @return  self
     */ 
    public function setStat(int $stat, string $statName)
    {
        $this->stats[$statName] = $stat;

        return $this;
    }


    public function changeExistingStat(string $statName, int $stat){

        if ($this->getSingleStat($statName) == null){
            return;
        }


        $this->setStat($stat, $statName);


    }



    /**
     * Get the value of level
     */ 
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set the value of level
     *
     * @return  self
     */ 
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Set the value of image_url
     *
     * @return  self
     */ 
    public function setImage_url($image_url)
    {
        $this->image_url = $image_url;

        return $this;
    }


    public function updateSecondaryStats(): self{

        // todo : calculate stats better

        // Store the current max health points
        $currentMaxHealthPoints = $this->maxHealthPoints;

        // Update max health points based on constitution
        $this->maxHealthPoints = $this->stats["con"] * 10;

        // On prend la différence entre avant et maintenant
        $healthPointDiff = $this->maxHealthPoints - $currentMaxHealthPoints;

        // On l'ajoute au points de vie (ex 100 + -50 = 50)
        $this->healthPoints =  min($this->maxHealthPoints, $this->healthPoints + $healthPointDiff);;

        // On change le reste des stats normalement.
        $this->attackSpeed = $this->stats["dex"];
        // todo : dodge chance
        $this->attackDamage = $this->stats["str"] * 2;
        $this->skillDamage = $this->stats["int"] * 2;

        return $this;

}

public function initializeHp(): self{

    $this->healthPoints = $this->maxHealthPoints;

    return $this;
}



/**
 * Get the value of maxHealthPoints
 */ 
public function getMaxHealthPoints(): int
{
        return $this->maxHealthPoints;
}


/**
 * Get the value of attackSpeed
 */ 
public function getAttackSpeed(): int
{
        return $this->attackSpeed;
}


/**
 * Get the value of attackDamage
 */ 
public function getAttackDamage(): int
{
        return $this->attackDamage;
}


/**
 * Get the value of skillDamage
 */ 
public function getSkillDamage(): int
{
        return $this->skillDamage;
}

    /**
     * Get the value of isDead
     */ 
    public function getIsDead(): bool
    {
        return $this->isDead;
    }
}

?>