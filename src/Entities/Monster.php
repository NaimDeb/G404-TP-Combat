<?php

final class Monster extends Entity {

    public function __construct(string $name, string $image_url = "defaultMonster.png")
    {
            parent::__construct($name, false);

            $this->image_url = "./assets/image/Monsters/" . $image_url;



    }
}


?>