<?php

final class Hero extends Entity
{

        protected int $maxHealthPoints;
        protected int $healthPoints;
        protected int $attackSpeed;
        protected int $attackDamage;
        protected int $skillDamage;

        use inDatabaseTrait;

        public function __construct(string $name, string $image_url = "defaultHero.png")
        {
                parent::__construct($name);

                $this->image_url = "./assets/image/Heroes/" . $image_url;

                $this->level = 1;

                // todo: Calculate health points
                $this->maxHealthPoints = 100;
                $this->healthPoints = $this->maxHealthPoints;



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



        public function updateSecondaryStats(): self{

                $healthPointDiff = $this->maxHealthPoints;

                $this->maxHealthPoints = $this->stats["con"] * 10;

                $healthPointDiff = $this->maxHealthPoints - $healthPointDiff;

                $this->healthPoints += $healthPointDiff;

                $this->attackSpeed = $this->stats["dex"] * 10;
                $this->attackDamage = $this->stats["str"] * 10;
                $this->skillDamage = $this->stats["int"] * 10;


                return $this;

        }



        /**
         * Get the value of maxHealthPoints
         */ 
        public function getMaxHealthPoints()
        {
                return $this->maxHealthPoints;
        }

        /**
         * Set the value of maxHealthPoints
         *
         * @return  self
         */ 
        public function setMaxHealthPoints($maxHealthPoints)
        {
                $this->maxHealthPoints = $maxHealthPoints;

                return $this;
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
         * Get the value of attackSpeed
         */ 
        public function getAttackSpeed()
        {
                return $this->attackSpeed;
        }

        /**
         * Set the value of attackSpeed
         *
         * @return  self
         */ 
        public function setAttackSpeed($attackSpeed)
        {
                $this->attackSpeed = $attackSpeed;

                return $this;
        }

        /**
         * Get the value of attackDamage
         */ 
        public function getAttackDamage()
        {
                return $this->attackDamage;
        }

        /**
         * Set the value of attackDamage
         *
         * @return  self
         */ 
        public function setAttackDamage($attackDamage)
        {
                $this->attackDamage = $attackDamage;

                return $this;
        }

        /**
         * Get the value of skillDamage
         */ 
        public function getSkillDamage()
        {
                return $this->skillDamage;
        }

        /**
         * Set the value of skillDamage
         *
         * @return  self
         */ 
        public function setSkillDamage($skillDamage)
        {
                $this->skillDamage = $skillDamage;

                return $this;
        }
}
