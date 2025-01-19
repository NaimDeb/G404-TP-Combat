<?php

final class HeroRepository extends AbstractRepository
{


    // todo : add competences
    public function fetchHeroByID(int $id): ?Hero
    {
        $query = "SELECT 
        hero.id, 
        hero.name, 
        hero.url_image, 
        hero.isDead, 
        hero.level,
        GROUP_CONCAT(CONCAT(herostat.stat_name, ': ', herostat.stat_value) SEPARATOR ', ') AS stats
        FROM 
            hero 
        JOIN 
            herostat 
        ON 
            hero.id = herostat.id_hero 
        WHERE 
            hero.id = :id
        GROUP BY 
            hero.id, hero.name, hero.url_image, hero.isDead, hero.level;";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        return HeroMapper::mapToObject($userData);
    }


    public function fetchAllHeroes(): array
    {
        $query = "SELECT 
        hero.id, 
        hero.name, 
        hero.url_image, 
        hero.isDead, 
        hero.level,
        GROUP_CONCAT(CONCAT(herostat.stat_name, ':', herostat.stat_value) SEPARATOR ',') AS stats
        FROM 
            hero 
        JOIN 
            herostat 
        ON 
            hero.id = herostat.id_hero 
        GROUP BY 
            hero.id, hero.name, hero.url_image, hero.isDead, hero.level;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userDataList = [];

        if ($usersData) {

            foreach ($usersData as $userData) {
                $userDataList[] = HeroMapper::mapToObject($userData);
            }
        }
        return $userDataList;
    }

    public function fetchAllDeadHeroes(): array
    {
        $query = "SELECT 
        hero.id, 
        hero.name, 
        hero.url_image, 
        hero.isDead, 
        hero.level,
        GROUP_CONCAT(CONCAT(herostat.stat_name, ': ', herostat.stat_value) SEPARATOR ', ') AS stats
        FROM 
            hero 
        JOIN 
            herostat 
        ON 
            hero.id = herostat.id_hero 
        WHERE
            hero.isDead = 1
        GROUP BY 
            hero.id, hero.name, hero.url_image, hero.isDead, hero.level;";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $usersData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $userDataList = [];

        if ($usersData) {

            foreach ($usersData as $userData) {
                $userDataList[] = HeroMapper::mapToObject($userData);
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
    public function createHero(array $data): Hero
    {

        // Checking if the data has a filename or not
        $filename = isset($data['filename']) ? $data["filename"] : "defaultHero.png";


        $query = "INSERT INTO hero (name, url_image) VALUES (:hero_name, :filename)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':hero_name', $data['hero_name'], PDO::PARAM_STR);
        $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
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


        return $this->fetchHeroByID($heroId);
    }
}
