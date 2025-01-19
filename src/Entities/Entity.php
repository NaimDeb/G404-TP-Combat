<?php

abstract class Entity {


    protected string $name;
    protected string $image_url;
    protected array $stats;
    protected int $level;
    protected int $healthPoints;
    
    
    public function __construct(string $name)
    {
        $this->name = $name;

        $this->stats = [
            "str" => 10,
            "int" => 10,
            "dex" => 10,
            "con" => 10,
        ];

        
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
}

?>