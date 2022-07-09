<?php
namespace App\Model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './Core/PHPMailer/src/Exception.php';
require './Core/PHPMailer/src/PHPMailer.php';
require './Core/PHPMailer/src/SMTP.php';


class Mymail
{
	private $mailer;

	public function __construct() 
	{
		$this->mailer = new PHPMailer();
		$this->mailer->isSMTP();
		$this->mailer->SMTPDebug = 0;
		$this->mailer->SMTPAuth = true;
		$this->mailer->SMTPSecure = 'tls';
		$this->mailer->Host = 'smtp.gmail.com';
		$this->mailer->Port = 587;
		$this->mailer->Username = "artistery.projetcms@gmail.com";
		$this->mailer->Password = "odmwqkjvqpebzjic";
		$this->mailer->SetFrom("artistery.projetcms@gmail.com", "Artistery Team");
	}

	/**
	 * @param string $subject
	 * @param string $body
	 * @param array $adressee
	 * @return void
	**/
	public function setupMyMail($subject, $body, $adressee) :void
	{
		$this->mailer->Subject = $subject;
		$this->mailer->Body = $body;
		foreach ($adressee as $email) {
			$this->mailer->AddAddress($email);
		}
	}

	/**
	 * @return string
	**/
	public function sendMyMail() :string
	{
		$resp = "";

		if (!$this->mailer->send()) {
			$resp = $this->mailer->ErrorInfo;
		} else {
			$resp = "OK";
		}

		return $resp;
	}

}