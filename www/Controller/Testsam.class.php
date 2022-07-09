<?php

    namespace App\Controller;

    use App\Core\Sql;
    use App\Model\Testsam as TestSamModel;
    use App\Model\Mymail as MymailModel;

    class TestSam
    {

        public function test()
        {
            $mail = new MymailModel();
            
            $addresse = array(
                "Samuel GUENIER" => "guenier.samuel@gmail.com"
            );
    
            $mail->setupMyMail("Test Sujet", "Test Body", $addresse);
    
            $response = $mail->sendMyMail();
    
            echo $response;
        }

    }