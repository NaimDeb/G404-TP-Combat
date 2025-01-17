<?php


class HeroService{

    public static function verifyHeroData(array $postData, array $fileData){



        $fileName = self::addToHeroFolder($fileData["hero_image"]);

        $postData["fileName"] = $fileName;

        return $postData;



    }


    private static function addToHeroFolder(array $fileData){



        $uploadDir = '../public/assets/image/Heroes/';
        $fileName = uniqid() . basename($fileData['name']);
        $uploadPath = $uploadDir . $fileName;
    
          
        move_uploaded_file($fileData['tmp_name'], $uploadPath);
        
        return $fileName;
    }

       

}
?>