<?php

namespace App\Core;


class Verificator
{

    public static function checkForm($config, $data, $file=null): array
    {
        $result =  [];
        $nbFields = 0;
        $nbdata = count($data);

        if(!is_null($file)){
            $nbdata += count($file);
        }

        if (isset($config['textAreas'])) {
            $nbFields += count($config['textAreas']);
        } 
        if(isset($config['inputs'])) {
            $nbFields += count($config['inputs']);
        } 
        if(isset($config['select'])) {
            $nbFields += count($config['select']);
        }

        if( $nbdata != $nbFields){
            die("Tentative de hack !!!!");
        }

        foreach ($config['inputs'] as $name=>$input){

            if(!isset($data[$name]) && !isset($files[$name])){
                $result[] = "Le champs ".$name." n'existe pas";
            }

            if(empty($data[$name]) && empty($files[$name]) && !empty($input["required"]) ){
                $result[] = "Le champs ".$name." ne peut pas être vide";
            }

            if($input["type"] == "email" && !self::checkEmail($data[$name]) ){
                $result[] = $input["error"];
            }

            if($input["type"] == "password" && empty($input["confirm"]) && !self::checkPassword($data[$name]) ){
                $result[] = $input["error"];
            }

            if ($input["type"] == "file" ) {
                if ($name == "cover" && !self::checkCover($files[$name])) {
                    $result[] = $input["error"];
                }
            }

            if(!empty($input["confirm"]) && $data[$name] != $data[$input["confirm"]]){
                $result[] = $input["error"];
            }

        }

        if (isset($config['textAreas'])) {
            foreach ($config['textAreas'] as $name=>$textArea) {
                if(!isset($data[$name]) ){
                    $result[] = "Le champs ".$name." n'existe pas";
                }

                if(empty($data[$name]) && !empty($textArea["required"]) ) {
                    $result[] = "Le champs ".$name." ne peut pas être vide";
                }
            }
        }


        return $result;

    }

    public static function checkEmail($email): bool
    {
       return filter_var($email, FILTER_VALIDATE_EMAIL);
    }


    public static function checkPassword($password): bool
    {

        return strlen($password)>=8
            && preg_match("/[0-9]/", $password, $match)
            && preg_match("/[a-z]/", $password, $match)
            && preg_match("/[A-Z]/", $password, $match)
            ;
    }

    public static function checkCover($cover)/*: bool*/
    {
        $format = array(
            'image/jpeg',
            'image/jpg',
            'image/png'
        );
        $maxsize = 2097152;
/*        $uniqueNb = time();*/

        if ((in_array($cover['type'], $format))) {
            $size = $cover['size'];
            if ($size >= $maxsize || $size > 0) {
                return true;
/*                $image_name = $_SESSION['id'] . '-' . $uniqueNb;
                $filename = $_FILES['picture1']['name'];
                $temp_array = explode(".", $filename);
                $extension = end($temp_array);
                $image_path1 = '../../../img/products/' . $image_name . '.' . $extension;
                $insert_bdd_pic1 = 'img/products/' . $image_name . '.' . $extension;*/
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


}
