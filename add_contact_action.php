
<?php

    include("connection.php");
    include('smtp/PHPMailerAutoload.php');
    $response = array();
    $conn = _connectodb();

    function InsertContact($conn,$data)
    {
        date_default_timezone_set('Asia/Kolkata');

      	$first_name = $_POST['name'];;
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $CreatedDate = date('Y-m-d');
        $CreatedTime = date('H:i:s');
        $holidays_query = "INSERT INTO contact (Name,Phone,Email,Message,CreatedDate,CreatedTime) VALUES('$first_name','$phone','$email','$message','$CreatedDate','$CreatedTime')";
            // print_r($holidays_query);exit;
        $response = _InsertTableRecords($conn, $holidays_query);
        $response['message'] = "We  will connect to you very soon";
        if ($response['message'] == 'We  will connect to you very soon') {
          $to = 'nirogyamcsp@gmail.com';
          $subject = "Nirogyam Csp Elder Care Foundation Enquiry";
          $txt = '<html>
            <head>
             <title>Nirogyam Csp Elder Care Foundation Enquiry</title>
            </head>
            <body> 
            <h4> <img src="https://www.nirogyamcspeldercare.com/assets/img/logo-email.png" height="50px" width="300px"></h4>
            <h2> New Enquiry</h2>

            <p>I hope this message finds you well. Thank you for reaching out. To proceed with Nirogyam Csp Elder Care Foundation Enquiry, I kindly request the following details: </p>
            <h4>Personal Information:</h4>
            <p> Name : '.$first_name.'
            </br>
            <p> Phone : '.$phone.'
            </br>
            <p> Email : '.$email.'
            </br>
            <p> Message : '.$message.'
            </br>
            </p>
            <p>Thanks!</p>
            </body>
            </html>';
         
          function smtp_mailer($to,$subject, $msg){
            $mail = new PHPMailer(); 
            $mail->IsSMTP(); 
            $mail->SMTPAuth = true; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Host = " concord.herosite.pro";
            $mail->Port = 587; 
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            //$mail->SMTPDebug = 2; 
            $mail->Username = "info@nirogyamcspeldercare.com";
            $mail->Password = "csp@2024";
            $mail->SetFrom("info@nirogyamcspeldercare.com");
            $mail->Subject = $subject;
            $mail->Body =$msg;
            $mail->AddAddress($to);
            $mail->SMTPOptions=array('ssl'=>array(
                'verify_peer'=>false,
                'verify_peer_name'=>false,
                'allow_self_signed'=>false
            ));
            if(!$mail->Send()){
                echo $mail->ErrorInfo;
            } else {
               $msg = 'success';
            }
          }
            echo smtp_mailer($to,$subject,$txt);
        } 
        return $response;
    }

    if(isset($_POST))
    {
    	// print_r($_POST);exit;
        $response = InsertContact($conn,$_POST);
    }
    else
    {
        $response['error'] = true;
        $response['message'] = "Technical Problem, Please try again later !";
    }
    echo json_encode($response);

?>