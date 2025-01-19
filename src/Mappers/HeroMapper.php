

<?php


class HeroMapper
{
    public static function MapToObject(array $data): Hero
    {

        $hero = new Hero($data["name"], $data["url_image"] );

        $hero->setId($data['id'], $data['url_image']);
        $hero->setLevel($data["level"]);

        foreach (explode(',', $data["stats"]) as $stat) {
            list($name, $value) = explode(':', $stat);
            $statName = trim($name);
            $value = intval(trim($value));
            $hero->changeExistingStat($statName, $value);
        }

        $hero->updateSecondaryStats();

        return $hero;
    }
}