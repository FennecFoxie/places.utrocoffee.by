<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
$file = $path.$filename;
$file_size = filesize($file);
$handle = fopen($file, "r");
$content = fread($handle, $file_size);
fclose($handle);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$header = "From: ".$from_name." <".$from_mail.">\r\n";
$header .= "Reply-To: ".$replyto."\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$header .= "This is a multi-part message in MIME format.\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$header .= $message."\r\n\r\n";
$header .= "--".$uid."\r\n";
$header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
$header .= $content."\r\n\r\n";
$header .= "--".$uid."--";
if (mail($mailto, $subject, "", $header)) {
echo "Successfully sent";
} else {
echo "Error sending message";
}
}

	$subject = "Места - UTRO Coffee";
	$to = "mesto@utrocoffee.by";
	// $to = "alice.levkovich@gmail.com";

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
//
// if(!$_FILES) {
// 	$photo = $_FILES['file']['tmp_name'];
// 	move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
// }

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";

$headers .= "From: UTRO COFFEE <mesto@utrocoffee.by>" . "\r\n";
$headers .= "Reply-To: <mesto@utrocoffee.by>" . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";


	if ($message != "") {
		if (
			mail($to, $subject, $message, $headers)
			// mail_attachment($photo, $my_path, "recipient@mail.org", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
		){
			echo "Success";
		}
		else {
			echo "Error";
		}
	}
	else {
		echo "Error";
	}

?>
