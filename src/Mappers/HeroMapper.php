

<?php


class HeroMapper
{
    public static function MapToObject(array $data): Hero
    {
        $hero = new Hero(
            $data['hero_name'],
            

        );

        $hero->setId($data['id']);

        if(isset($data['filename'])){
        $hero->setImage_url($data['filename']);
        }


        foreach ($data as $stat => $value) {

            if (!in_array($stat, ['hero_name', 'filename', 'id'])) {

            $hero->changeExistingStat($stat, $value);

            }

        }

        



        return $hero;
    }
}