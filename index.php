<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];
    $rl = $_POST['receptorsList'];
    $SMTPHost = $_POST['SMTPHost'];
    $SMTPUsername = $_POST['SMTPUsername'];
    $SMTPPassword = $_POST['SMTPPassword'];
    $SMTPSecure = $_POST['SMTPSecure'];
    $SMTPPort = $_POST['SMTPPost'];

    $receptorList = explode("\n",$rl);

    require 'PHPMailer/PHPMailerAutoload.php';

    function send($recepEmail,$n,$s,$e,$m,$SMTPHost,$SMTPUsername,$SMTPPassword,$SMTPSecure,$SMTPPort){

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $SMTPHost;                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $SMTPUsername;             // SMTP username
            $mail->Password = $SMTPPassword;                       // SMTP password
            $mail->SMTPSecure = $SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $SMTPPort;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($e, $n);
            $mail->addReplyTo($e, $n);
            $mail->addAddress($recepEmail);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $s;
            $mail->Body    = $m;
            $mail->AltBody = $m;

            if($mail->send()){
                return true;
            }else{
                return false;
            }

        } catch (Exception $e) {
            $Catchederror = '<div class="alert alert-danger alert-dismissible">
            <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
            Message could not be sent. Mailer Error: '. $mail->ErrorInfo .'</div>';
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site title -->
    <title>PHP Mailer One To Many</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!--Font Awesome css -->
    <link href="css/font-awesome.css" rel="stylesheet">

    <!-- Site css -->
    <link href="style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body>
    
    <div class="container">
        <form class="contact-form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <h1 class="text-center">PHP Mailer One To Many</h1>
            <div class="row">
                <div class="smtp text-center col-md-6">
                    <h2 class="text-center">SMTP</h2>
                    <p>You can get those information from your hosting</p>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="SMTP Host" name="SMTPHost" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="SMTP Username" name="SMTPUsername" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="password" placeholder="SMTP Password" name="SMTPPassword" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="SMTP Secure (TLS / SSL)" name="SMTPSecure" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="SMTP Port" name="SMTPPort" value=""/>
                    </div>
                    
                </div>

                <div class="sender text-center col-md-6">
                    <h2 class="text-center">Sender</h2>
                    <p>Your informations and your message</p>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="Name" name="name" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="text" placeholder="Subject" name="subject" value=""/>
                    </div>
                    <div class="form-group">
                        <input class="form-input" type="email" placeholder="Email" name="email" value=""/>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="HTML Message" name="msg" value=""></textarea>
                    </div>
                    
                </div>
    
                <div class="receptors text-center col-md-6">
                    <h2 class="text-center">Receptors List</h2>
                    <p>Please to devid emails by a new line, otherword put on email by line</p>
                    <div class="form-group">
                        <textarea style="height: 297px" placeholder="Receptors list" name="receptorsList" value=""></textarea>
                    </div>
                </div>
                <div class="action text-center col-md-6">
                    <input class="btn btn-success btn-send" type="submit" value="Send Message">
                    <div class="result">
                        <?php
                            if(isset($receptorList)){
                                foreach($receptorList as $receptor){
                                    if(send($receptor,$name,$subject,$email,$msg,$SMTPHost,$SMTPUsername,$SMTPPassword,$SMTPSecure,$SMTPPort)){
                                        echo '<div id="alert" class="alert alert-success alert-dismissible">
                                        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
                                        Message successfully sent to '. $receptor .'</div>';
                                    }else{
                                        /*echo '<div id="alert" class="alert alert-warning alert-dismissible">
                                        <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
                                        Message can\'t be sent to '. $receptor .'</div>';*/
                                        if(isset($Catchederror)){
                                            echo $Catchederror;
                                        }
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>   
   
   
    <!-- jQuery -->
    <script src="js/jquery-3.1.1.min.js"></script>

    <!-- Bootstrap js-->
    <script src="js/bootstrap.min.js"></script>

    <!-- Main custom-->
    <script src="js/custom.js"></script>

</body>

</html>
