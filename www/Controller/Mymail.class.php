<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Mymail as MyMailModel;


class Mymail
{

	/**
	 * @return void
	**/
	public function testMail() :void
	{
		$mail = new MyMailModel();
		
		$addresse = array(
			"Samuel GUENIER" => "guenier.samuel@gmail.com"
		);

		$mail->setupMyMail("Test Sujet", "Test Body", $addresse);

		$response = $mail->sendMyMail();

		echo $response;
	}


	/**
	 * @param string $login
	 * @param string $email
	 * @return string
	**/
	public function sendConfirmationUser($login, $email) :string
	{

		$mail = new MyMailModel();
		$addresse = array();

		if ( $login == "" ) {
			die("Error: login is required to continue. Function : SendConfirmationUser");
		}

		if ( $email == "" ) {
			die("Error email is required to continue. Function SendConfirmationUser");
		}

		$addresse[$login] = $email;

		$mail_subject = "Artistery : User confirmation.";
		$mail_body = "Yeah man, Welcome to the artistery family $login.";

		$mail->setupMyMail($mail_subject, $mail_body, $addresse);

		$resp = $mail->sendMyMail();

		return $resp;
	}


}