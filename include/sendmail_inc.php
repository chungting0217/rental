<?php

    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = false;                                        
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
	$mail->SMTPSecure = "ssl";
    $mail->CharSet = "utf-8";
    $mail->Encoding = "base64";
    $mail->WordWrap = 500;
    
	$mail->Username = "u10706120@ms.ttu.edu.tw"; // SMTP username
	$mail->Password = "a741862953andy";
    $mail->SetFrom('u10706120@ms.ttu.edu.tw', 'rentalsport管理員');
    $mail->Subject = $Subject;
    $mail->AddAddress($Recipient, $Recipient);
    $Notice = $Recipient . " 您好\n\n" . $Message . "\n\n此信件為系統自動發出請勿回覆，謝謝！\n";
    $mail->Body = $Notice;
    $mail->Send();
    $mail->ClearAllRecipients();

?>