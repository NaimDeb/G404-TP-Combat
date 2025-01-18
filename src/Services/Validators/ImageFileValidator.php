<?php



/**
 * Verifies if the value is an image
 */
class ImageFileValidator implements ValidationContract
{
    public function validate($value): bool
    {
        if (!isset($value)){
            return true;
        }

        if(!getimagesize($value['tmp_name'])){
            var_dump("image size bouuuu");
            return false;
        }

        if(!str_contains($value['type'], "image")){
            var_dump("contains not");
            return false;
        }



        return true;
    }
}



