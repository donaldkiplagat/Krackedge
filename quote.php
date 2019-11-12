<?php
if(isset($_POST['submit'])){
    $to = "donatello54611@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $client_name = $_POST['client_name'];
    $business = $_POST['business'];
    $category = $_POST['category'];
    $phone_number = $_POST['phone_number'];
    $service = $_POST['service'];
    $package = $_POST['package'];
    $additional_request = $_POST['additional_request'];

    $message = $client_name . " requested a quote of the following service:" ."\n" .$service ."\n". "With the following package: ".$package. "\n"."Additional request/inquiry: ".$additional_request ;
    $message2 = "Here is a copy of your message " . $client_name . " requested a quote of the following service:" ."\n" .$service ."\n". "With the following package: ".$package. "\n"."Additional request/inquiry: ".$additional_request ;

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    // echo "Mail Sent. Thank you " . $client_name . ", we will contact you shortly.";
    header('Location: thankyou.html');
    // You cannot use header and echo together. It's one or the other.

    }
?>
