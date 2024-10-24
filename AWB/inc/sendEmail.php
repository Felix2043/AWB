<?php

$siteOwnersEmail = 'https://fregmunt-s.tplinkdns.com/hartelov43@gmail.com';

if($_POST) {

   $fname = trim(stripslashes($_POST['contactFname']));
   $lname = trim(stripslashes($_POST['contactLname']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check First Name
	if (strlen($fname) < 2) {
		$error['fname'] = "Проверте поле - Фамилия.";
	}
	// Check Last Name
	if (strlen($lname) < 2) {
		$error['lname'] = "Проверте поле - Имя.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Проверте поле - email.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Введите ваше сообщение. Ограничение в 15 слов.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }

	// Set Name
	$name = $fname . " " . $lname;

   // Set Message
   $message .= "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Ваш запрс отправлен на наш почтовый адресс. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Что то  пошло не так, повторите попытку по позже."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['fname'])) ? $error['fname'] . "<br /> \n" : null;
		$response .= (isset($error['lname'])) ? $error['lname'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>
