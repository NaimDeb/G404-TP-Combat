<?php

class HeroRepository {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function fetchUserByID(int $id) : ?Hero  {
        $query = "SELECT * FROM hero WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$userData) {
            return null;
        }

        return HeroMapper::mapToObject($userData);

    }

    public function fetchAll() : array  {
        $query = "SELECT * FROM hero";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $usersData = $stmt->fetch(PDO::FETCH_ASSOC);

        $userDataList = [];

        if($usersData) {

            foreach ($usersData as $userData) {
                HeroMapper::mapToObject($userData);
            }



        }
        
        
        return $userDataList;

    }

    public function createUser($name) {
        $query = "INSERT INTO heroes (name, power) VALUES (:name, :power)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':power', $power, PDO::PARAM_STR);
        $stmt->execute();


    }
}

?>