<?php

if(isset($_POST['submit'])){
  // robot detection
  $honeypot = $_POST["email"];

  if(!empty($honeypot)) {
    echo "BAD ROBOT!";
    exit;
  }

  $client_name = $_POST['client_name'];
  $baruameme = $_POST['baruameme'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];


  date_default_timezone_set('Etc/UTC');

  require 'PHPMailerAutoload.php';
  require 'credential.php';

  //Create a new PHPMailer instance
  $mail = new PHPMailer;
  //$mail->SMTPDebug = 4;                               // Enable verbose debug output


  //Tell PHPMailer to use SMTP - requires a local mail server
  //Faster and safer than using mail()
  $mail->isSMTP();
  $mail->Host = 'mail.krackedgecreative.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = EMAIL;                 // SMTP username
  $mail->Password = PASS;                           // SMTP password
  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 587;                                    // TCP port to connect to



  $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
  );
  //Use a fixed address in your own domain as the from address
  //**DO NOT** use the submitter's address here as it will be forgery
  //and will cause your messages to fail SPF checks
  $mail->setFrom(EMAIL, 'Krackedge Creative');
  //Send the message to yourself, or whoever should receive contact for submissions
  $mail->addAddress(EMAIL, 'Krackedge Creative');
  $mail->addBCC(EMAIL2);

  //Put the submitter's address in a reply-to header
  //This will fail if the address provided is invalid,
  //in which case we should ignore the whole request
  if ($mail->addReplyTo($baruameme,$baruameme)) {
      $mail->Subject = '[Krackedge Creative Contact Form] - '.$subject;
      //Keep it simple - don't use HTML
      $mail->isHTML(false);
      //Build a simple message body

      $mail->Body = <<<EOT
Name: {$client_name}
Email: {$baruameme}


{$client_name} wrote the following:

{$message}
EOT;


      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


     // echo 'Mailer Error: ' . $mail->ErrorInfo;

      //Send the message, check for errors
      if (!$mail->send()) {
          //The reason for failing to send will be in $mail->ErrorInfo
          //but you shouldn't display errors to users - process the error, log it on your server.
          header("Location:error.html");
      } else {
        $mail->ClearAllRecipients();
        $mail ->Subject = '[Krackedge Creative Inquiry Received] - '.$subject;
        $mail->Body = <<<EOT
Greetings {$full_name},

Thank you for contacting our team. Your inquiry has been received and a response shall be communicated as soon as possible. Thank you for choosing Krackedge Creative.

The details of your inquiry are as shown below:

Name: {$client_name}
Email: {$baruameme}

{$message}

Kind Regards,
Krackedge Creative Team
EOT;
        $mail->AddAddress($baruameme);
        $mail->Send();

        header("Location:thankyou.html");
      }
  } else {
    header("Location:error.html");
  }
}
?>
