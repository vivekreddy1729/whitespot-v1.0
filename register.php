<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('usersdata.db');
    }
}

function redirect2(){
  header('Location:confirmation-sent.php');
  exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';

$db = new MyDB();
$result = 0;

if (isset($_POST['submit-register'])){
  $username = strtolower($_POST['username']);
  $email = strtolower($_POST['email']);
  $password = $_POST['password'];


  $usernamecheck = $db->query("SELECT count(*) as count FROM usersdata Where username = '$username'");
  $no_of_users = $usernamecheck->fetchArray();
  if (empty($username) or empty($password) or empty($email)) {
    $result = 1;
  }
  else{

    if ($no_of_users['count']>0) {
        $result = 2;
    }
    else{

      #Checking for wether this email is already registered
      $emailcheck = $db->query("SELECT count(*) as count FROM usersdata Where email = '$email'");
      $no_of_emails = $emailcheck->fetchArray();
      
      if ($no_of_emails['count']>0) {
          $result = 3;
      }
      else{
          #Checking the password length
          if(strlen($password)<8){
            $result = 6;
          }
          else{
            #Checking wether password is alphanumeric
            if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password)) {
              #Checking for the username is alphanumeric or not
              if (preg_match('/[0-9]/', $username) && preg_match('/[a-z]/', $username)) {

                if ($result == 0) {
                  $token = 'qadfiahdfnjansdfjSDAFHAIUDFHNJ123456789';
                  $token = str_shuffle($token);
                  $token = substr($token, 0, 10);

                  #sending the mail
                  // Instantiation and passing `true` enables exceptions
                  $mail = new PHPMailer(true);

                  try{
                    $mail->SMTPDebug = 2;                      // Enable verbose debug output
                      //$mail->isSMTP();                                            // Send using SMTP
                      $mail->Host = 'smtp1.gmail.com';                    // Set the SMTP server to send through
                      $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                      $mail->Username = 'xyz@gmail.com';                     // SMTP username
                      $mail->Password = 'yourpassword';                               // SMTP password
                      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; 
                      $mail->Port = 465; 

                      $mail->setFrom('xyz@gmail.com', 'Shortcuts');
                      $mail->addAddress($email);               // Name is optional

                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = 'Email Address Confirmation';
                      $mail->Body    = "Please Click on below link to confirm you Email Address<br/> <a href='http://anydoubts.co.in/website/confirm.php?username=$username&token=$token'>Comfirm Email</a>";

                      

                      if($mail->send()){
                        $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
                        date_default_timezone_set('Asia/Kolkata');
                      $currentTime = date( 'd-m-Y h:i:s A', time () );
                      $db->query("INSERT INTO usersdata (username, email, password, token, confirmation, createdon) VALUES ('$username','$email', '$hashedpassword', '$token', 0, '$currentTime')");
                      redirect2();
                      }
                    }catch(Exception $e){
                      $result = 8;
                    }
                  #End of sending the mail
                  
                }
              }
              else {
                $result= 7;
              }

              
            }
            else {
              $result= 5;
            }

          }

      }
      
    }
    
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Whitespot</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="images/favicon.png" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="css/responsive.css">
   </head>
   <body>
    
      <!-- loader END -->
        <!-- Sign in Start -->
        <section class="sign-in-page">
          <div id="container-inside">
              <div id="circle-small"></div>
              <div id="circle-medium"></div>
              <div id="circle-large"></div>
              <div id="circle-xlarge"></div>
              <div id="circle-xxlarge"></div>
          </div>
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center pt-5">
                        <div class="sign-in-detail text-white">
                            <a class="sign-in-logo mb-5" href="#"><h1 style="color: white;">Whitespot</h1></a>
                            <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                                <div class="item">
                                    <img src="images/login/1.jpg" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Manage your orders</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                                <div class="item">
                                    <img src="images/login/2.jpg" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Manage your orders</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                                <div class="item">
                                    <img src="images/login/3.jpg" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Manage your orders</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pt-5">
                        <div class="sign-in-from bg-white" style="margin-top: 50px;padding-top: 30px; padding-bottom: 70px;">
                            <h1 class="mb-0">Register</h1>
                            <form class="mt-4" name="RegistrationForm" action="register.php" method="POST" enctype="multipart/form-data">
                              <?php
                                  if ($result == 1) {
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      All fields are required!!
                                    </div>";
                                  }
                                  elseif($result == 2){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Username is already taken
                                    </div>";
                                  }
                                  elseif($result == 3){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Email is already registered
                                    </div>";
                                  }
                                  elseif($result == 6){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Password length should be more than 8 Characters
                                    </div>";
                                  }
                                  elseif($result == 7){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                    Username didnt met the criteria! Should be combination of Alphabets and Numerics
                                    </div>";
                                  }
                                  elseif($result == 5){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Password should be combination of Alpahbets and numerics
                                    </div>";
                                  }
                                  elseif($result == 8){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Unable to send confirmation mail
                                    </div>";
                                  }
                                ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">username</label>
                                    <input type="text" class="form-control mb-0" id="exampleInputEmail1" name="username" placeholder="username">
                                    <small>Letters a-z, Numbers 0-9</small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail2">Email address</label>
                                    <input type="email" class="form-control mb-0" id="exampleInputEmail2" name="email" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control mb-0" id="exampleInputPassword1" name="password" placeholder="Password">
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label" for="customCheck1">I accept <a href="#">Terms and Conditions</a></label>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right" name="submit-register">Register</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="login.php">Log In</a></span>
                                    <ul class="iq-social-media">
                                        <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                        <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                        <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Sign in END -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="js/waypoints.min.js"></script>
      <script src="js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="js/wow.min.js"></script>
      <!-- lottie JavaScript -->
      <script src="js/lottie.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="js/smooth-scrollbar.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="js/custom.js"></script>
   </body>

</html>
