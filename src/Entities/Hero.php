<?php

final class Hero extends Entity{


    use inDatabaseTrait;

    public function __construct(string $name, string $image_url = "defaultHero.png")
    {
        parent::__construct($name);

        $this->image_url = "./assets/image/Heroes/" . $image_url;

        $this->level = 1;

        // todo: Calculate health points
        $this->healthPoints = 100;
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

        /**
         * Get the value of image_url
         */ 
        public function getImage_url()
        {
                return $this->image_url;
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