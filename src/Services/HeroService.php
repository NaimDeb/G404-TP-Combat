<?php


class HeroService{

    public static function verifyHeroData(array $postData, array $fileData){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid request method');
        }

        // Required fields
        $requiredPostFields = ['hero_name', 'str', 'int', 'dex', 'con'];

        foreach ($requiredPostFields as $field) {
            if (!isset($postData[$field])) {
                throw new Exception("Missing field: $field");
            }
        }
        
                if (!is_string($postData['hero_name']) || strlen($postData['hero_name']) > 100) {
                    throw new Exception('Invalid hero name');
                }

        // $_FILE field

        
        if (!isset($fileData['hero_image']) || !getimagesize($fileData['hero_image']['tmp_name']) || $fileData['hero_image']['type'] != 'image/png') {
            throw new Exception('Invalid hero image');
        }


        



        // Attributs
        $attributes = ['str', 'int', 'dex', 'con'];
        $total = 0;


        foreach ($attributes as $attribute) {
            $postData[$attribute] = (int)$postData[$attribute];

            if ($postData[$attribute] <= 0 || $postData[$attribute] > 20 ) {
                throw new Exception("Un attribut n'a pas un bon numéro");
            }

            $total += $postData[$attribute];
        }

        if ($total > 50) {
            throw new Exception('Total attribute points exceed 50');
        }



        $fileName = self::addToHeroFolder($fileData);

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