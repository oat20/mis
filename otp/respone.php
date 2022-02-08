<?php
date_default_timezone_set('Asia/Bangkok');

$muemail = explode('@', $_POST['muemail']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTHEN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="./index.html"><i class="fa fa-arrow-left fa-fw"></i></a>
    </nav>

    <div class="container mt-5">
        <?php
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if($muemail[1] == 'mahidol.ac.th'){

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://doc.ph.mahidol.ac.th/phonebook/api/authen_withemail.php");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(
                array(
                    'account' => $_POST['muemail']
                )
            ));

            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $server_output = curl_exec($ch);
            curl_close ($ch);
            
            $server_output_array = json_decode($server_output, true);
            if($server_output_array['responseCode'] == '200'){
                echo '<div class="alert alert-success mb-3">รหัส OTP ได้ส่งไปยังอีเมล <strong><em>'.$_POST['muemail'].'</em></strong></div>';
                var_dump($server_output);

                //send email
                ini_set('SMTP','mumail.mahidol.ac.th');
                ini_set('smtp_port',25);

                $otp = date('yhi');

                $strTo = $_POST['muemail'];
                $strSubject = "=?UTF-8?B?".base64_encode("รหัส OTP ของคุณคือ ".$otp)."?=";
                $strHeader = "MIME-Version: 1.0" . "\r\n";
                $strHeader .= "Content-type: text/html; charset=utf-8"."\r\n"; 
                $strHeader .= "From: ".strtoupper($_SERVER['HTTP_HOST'])."<".$_SERVER['HTTP_HOST']."@".$_SERVER['HTTP_HOST'].">";
                $strMessage = "<h1>Your OTP is ".$otp."</h1>
                    <p>".$server_output_array['responseData']['name']." ".$server_output_array['responseData']['surname']."</p>
                    <p><strong>ตำแหน่งาน</strong> ".$server_output_array['responseData']['job']['job']."</p>
                    <p><strong>ส่วนงาน</strong> ".$server_output_array['responseData']['office']['division']."</p>";

                $flgSend = @mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
                
            }else{
                echo '<div class="alert alert-danger mb-3">ERROR</div>';

                var_dump($server_output);
            }

        }else{

            echo '<div class="alert alert-danger">ERROR</div>';

        }

        }else{
            echo '<div class="alert alert-danger">ERROR</div>';
        }
        ?>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>
</body>
</html>