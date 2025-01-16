<?php

abstract class Entity {


    protected int $hp;
    protected string $name;
    protected string $image_url;
    // protected int $stat_strength;                                                                                                    
    // protected int $stat_intelligence;                                                                                                    
    // protected int $stat_dexterity;                                                                                                    
    // protected int $stat_constitution;                                                                                                    

    /**
     * Get the value of hp
     */ 
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Set the value of hp
     *
     * @return  self
     */ 
    public function setHp($hp)
    {
        $this->hp = $hp;

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
}

?>