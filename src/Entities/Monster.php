<?php

final class Monster extends Entity {

    public function __construct(string $name, string $image_url = "defaultHero.png")
    {
            parent::__construct($name);

            $this->image_url = "./assets/image/Heroes/" . $image_url;



    }
}


?>