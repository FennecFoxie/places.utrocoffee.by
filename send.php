<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	$subject = "Места - UTRO Coffee";
	// $to = "mesto@utrocoffee.by";
	$to = "alice.levkovich@gmail.com";

	$message = "";

	if (isset($_POST['name']) && $_POST['name'] != "") {
		$message .= "Имя: " . $_POST['name'] . "\r\n";
	}
	if (isset($_POST['phone']) && $_POST['phone'] != "") {
		$message .= "Телефон: " . $_POST['phone'] . "\r\n";
	}
	if (isset($_POST['description']) && $_POST['description'] != "") {
		$message .= "Описание: " . $_POST['description'] . "\r\n";
	}


	if(isset($_FILES['photo']))
	{
		//Get uploaded file data
	 $file_tmp_name    = $_FILES['photo']['tmp_name'];
	 $file_name        = $_FILES['photo']['name'];
	 $file_size        = $_FILES['photo']['size'];
	 $file_type        = $_FILES['photo']['type'];
	 $file_error       = $_FILES['photo']['error'];

	 //read from the uploaded file & base64_encode content for the mail
	 $handle = fopen($file_tmp_name, "r");
	 $content = fread($handle, $file_size);
	 fclose($handle);
	 $encoded_content = chunk_split(base64_encode($content));

			 $boundary = md5("utrocoffee");

$headers = "MIME-Version: 1.0" . "\r\n";

$headers .= "From: UTRO COFFEE <mesto@utrocoffee.by>" . "\r\n";
$headers .= "Reply-To: <mesto@utrocoffee.by>" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";

        //plain text
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=utf-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($message));


				//attachment
			        $body .= "--$boundary\r\n";
			        $body .="Content-Type: $file_type; name=".$file_name."\r\n";
			        $body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
			        $body .="Content-Transfer-Encoding: base64\r\n";
			        $body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n";
			        $body .= $encoded_content;

				$sentMail = mail($to, $subject, $body, $headers);

				    if($sentMail) //output success or failure messages
				    {
				        echo 'Ваше сообщение успешно отправлено. Мы свяжемся с вами в ближайшее время.';
				    }else{
				        echo 'Что-то пошло не так.. Поробуйте отправить сообщение позже или свяжитесь с нами любым другим способом.';
				    }

}
?>
