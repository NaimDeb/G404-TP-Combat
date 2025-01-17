

<?php


class HeroMapper
{
    public static function MapToObject(array $data): Hero
    {
        $hero = new Hero(
            $data['hero_name'],
            $data['filename']

        );

        $hero->setId($data['id']);


        foreach ($data as $stat => $value) {

            if (!in_array($stat, ['hero_name', 'filename', 'id'])) {

            $hero->changeExistingStat($stat, $value);

            }

        }

        



        return $hero;
    }
}