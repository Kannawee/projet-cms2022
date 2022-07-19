<?php

namespace App\Core;


class Verificator
{

    public static function checkForm($config, $data, $files=null): array
    {
        $result =  [];
        $nbFields = 0;
        $nbdata = count($data);

        // if ($data['csrf']!=$_SESSION['csrf']) {
        //     die("Tentative de hack !!!");
        // }

        if(!is_null($files)){
            $nbdata += count($files);
        }

        if (isset($config['textAreas'])) {
            $nbFields += count($config['textAreas']);
        } 
        if (isset($config['inputs'])) {
            $nbFields += count($config['inputs']);
        } 
        if (isset($config['select'])) {
            $nbFields += count($config['select']);
        }
        if (isset($config['checkbox'])) {
            foreach ($config['checkbox'] as $name => $value) {
                if (in_array($name, array_keys($data))) {
                    $nbFields += 1;
                }
            }
        }

        if ( $nbdata != $nbFields) {
            die("Tentative de hack !!!!");
        }

        if (isset($config['inputs'])) {
            foreach ($config['inputs'] as $name=>$input){

                if (!isset($data[$name]) && !isset($files[$name])) {
                    $result[] = "Le champs ".$name." n'existe pas";
                }

                if (empty($data[$name]) && empty($files[$name]) && !empty($input["required"]) ) {
                    $result[] = "Le champs ".$name." ne peut pas être vide";
                }

                if (!empty($input["minLength"]) && isset($data[$name]) && strlen($data[$name])<$input["minLength"]) {
                    $result[] = "The field ".$name." must be at least ".$input["minLength"]." characters";
                }

                if (!empty($input["maxLength"]) && isset($data[$name]) && strlen($data[$name])>$input["maxLength"]) {
                    $result[] = "The field ".$name." must be maximum".$input["maxLength"]." characters long";
                }

                if ($input["type"] == "email" && !self::checkEmail($data[$name]) ) {
                    $result[] = $input["error"];
                }

                if ($input["type"] == "password" && empty($input["confirm"]) && !self::checkPassword($data[$name]) ) {
                    $result[] = $input["error"];
                }

                if ($input["type"] == "file" ) {
                    if ($name == "cover" && !self::checkCover($files[$name])) {
                        $result[] = $input["error"];
                    }
                }

                if (!empty($input["confirm"]) && $data[$name] != $data[$input["confirm"]]) {
                    $result[] = $input["error"];
                }

            }
        }

        if (isset($config['textAreas'])) {
            foreach ($config['textAreas'] as $name=>$textArea) {
                if (!isset($data[$name]) ) {
                    $result[] = "Le champs ".$name." n'existe pas";
                }

                if (empty($data[$name]) && !empty($textArea["required"]) ) {
                    $result[] = "Le champs ".$name." ne peut pas être vide";
                }
            }
        }

        if (isset($config['select'])) {
            foreach ($config['select'] as $name=>$select){

                if (!isset($data[$name])) {
                    $result[] = "Le champs ".$name." n'existe pas";
                }

                if (empty($data[$name]) && !empty($select["required"]) ) {
                    $result[] = "Le champs ".$name." ne peut pas être vide";
                }

                if (!empty($data[$name]) && !empty($select['options']) && !in_array($data[$name], array_keys($select['options']))) {
                    $result[] = "The value muste be in the options of the select you hacker.";
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
