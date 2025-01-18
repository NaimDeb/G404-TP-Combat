<?php

final class HeroRepository extends AbstractRepository{


    public function fetchUserByID(int $id) : ?Hero  {
        $query = "SELECT * FROM hero WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$userData) {
            return null;
        }

        // todo: heromapper
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

    /**
     * array (size=6)
     * 'hero_name' => string 'Jordan' (length=6)
     * 'str' => int 10
     * 'int' => int 10
     * 'dex' => int 10
     * 'con' => int 10
     * 'fileName' => string '678a06c585c75firefox_4GYvhnVBtu.png' (length=35)
     */
    public function createHero(array $data): Hero{

        $filename = isset($data['filename']) ? $data["filename"] : "defaultHero.png";

        $query = "INSERT INTO hero (name, url_image) VALUES (:hero_name, :filename)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hero_name', $data['hero_name'], PDO::PARAM_STR);
        $stmt->bindParam(':filename', $filename , PDO::PARAM_STR);
        $stmt->execute();

        $heroId = $this->db->lastInsertId();


        // On insère les stats
        $query = "INSERT INTO herostat (id_hero, stat_name, stat_value) VALUES (:id_hero, :stat_name, :stat_value)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            if ($key !== 'hero_name' && $key !== 'filename') {
                $stmt->bindParam(':id_hero', $heroId, PDO::PARAM_INT);
                $stmt->bindParam(':stat_name', $key, PDO::PARAM_STR);
                $stmt->bindParam(':stat_value', $value, PDO::PARAM_STR);
                $stmt->execute();
            }
        }

        $data["id"] = $heroId;

        return HeroMapper::MapToObject($data);




    }


}

?>