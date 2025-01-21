<?php

final class Hero extends Entity
{
        use inDatabaseTrait;

        public function __construct(string $name, string $image_url = "defaultHero.png", bool $isDead = false)
        {
                parent::__construct($name, $isDead);

                $this->image_url = "./assets/image/Heroes/" . $image_url;

        }


        public function dieForever(){
                $this->isDead = true;
                $heroRepo = new HeroRepository;

                $heroRepo->updateHero($this);
        }

}
