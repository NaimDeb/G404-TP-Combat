<?php

final class Hero extends Entity{


    use inDatabaseTrait;


    public function __construct(int $id,string $name, int $hp = 100, string $image_url = "defaultHero.png")
    {
        $this->id = $id;
        $this->name = $name;
        $this->hp = $hp;
        $this->image_url = "./assets/image/Heroes/" . $image_url;

    }





        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }
}


?>