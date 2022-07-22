<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('usersdata.db');
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
require 'vendor/autoload.php';


$db = new MyDB();
$result = 0;

if (isset($_POST['submit-login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  $usernamecheck = $db->query("SELECT count(*) as count FROM usersdata WHERE username='$username'");
  $no_of_users = $usernamecheck->fetchArray();
  if (empty($username) or empty($password)) {
    $result = 1;
  }else{
    $sql = $db->query("SELECT password, confirmation, token, email FROM usersdata WHERE username='$username'");
      if ($no_of_users['count']>0) {
            $data = $sql->fetchArray();
            if (password_verify($password, $data['password'])) {
              if ($data['confirmation'] == 0){
                #sending the mail
                // Instantiation and passing `true` enables exceptions
                $token = $data['token'];
                $email = $data['email'];
                $mail = new PHPMailer(true);

                try{
                  $mail->SMTPDebug = 2;                      // Enable verbose debug output
                  //$mail->isSMTP();                                            // Send using SMTP
                  $mail->Host = 'smtp1.gmail.com';                    // Set the SMTP server to send through
                  $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                  $mail->Username = 'fantasybennett@gmail.com';                     // SMTP username
                  $mail->Password = 'ammananna1729';                               // SMTP password
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; 
                  $mail->Port = 465; 

                  $mail->setFrom('fantasybennett@gmail.com', 'Shortcuts');
                  $mail->addAddress($email);               // Name is optional

                  $mail->isHTML(true);                                  // Set email format to HTML
                  $mail->Subject = 'Email Address Confirmation';
                  $mail->Body    = "Please Click on below link to confirm you Email Address<br/> <a href='http://anydoubts.co.in/website/confirm.php?username=$username&token=$token'>Comfirm Email</a>";

                  if($mail->send()){
                              $result = 4;
                    }
                  }catch(Exception $e){
                    $result = 5;
                  }
                  #End of sending the mail
                    }
                    else {
                      $_SESSION['username']=$username;
                      header('Location:home.php');
                    }
                } else
                  $result = 3;
      } else {
        $result = 2;
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
      <title>White Spot</title>
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
                                    <h4 class="mb-1 text-white">Find new friends</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                                <div class="item">
                                    <img src="images/login/2.jpg" class="img-fluid mb-4" alt="logo"> 
                                    <h4 class="mb-1 text-white">Connect with the world</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                                <div class="item">
                                    <img src="images/login/3.jpg" class="img-fluid mb-4" alt="logo">
                                    <h4 class="mb-1 text-white">Create new events</h4>
                                    <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  pt-5">
                        <div class="sign-in-from bg-white" style="margin-top: 50px;padding-top: 30px; padding-bottom: 70px;">
                            <h1 class="mb-0">Sign in</h1>
                            <form class="mt-4" name="LoginForm" action="login.php" method="POST" enctype="multipart/form-data">
                              <?php
                                if ($result == 3) {
                                  echo "<div class=\"alert alert-secondary\" role=\"alert\" style=\"background-color:#9e0f86; color:#e2ebef;\">
                                    Wrong Shot! Credentials didn't match
                                  </div>";
                                }
                                elseif($result == 2){
                                  echo "<div class=\"alert alert-secondary\" role=\"alert\" style=\"background-color:#9e0f86; color:#e2ebef;\">
                                    Reel is missing! No account with that Username
                                  </div>";
                                }
                                elseif($result == 1){
                                  echo "<div class=\"alert alert-secondary\" role=\"alert\" style=\"background-color:#9e0f86; color:#e2ebef;\">
                                    Incomplete Script!! All fields are required
                                  </div>";
                                }
                                elseif($result == 4){
                                  echo "<div class=\"alert alert-secondary\" role=\"alert\" style=\"background-color:#9e0f86; color:#e2ebef;\">
                                    Your Email is not confirmed! We sent the Email with confirmation link Again!!
                                  </div>";
                                }
                                elseif($result == 5){
                                  echo "<div class=\"alert alert-secondary\" role=\"alert\" style=\"background-color:#9e0f86; color:#e2ebef;\">
                                    There is an issue sending email!!
                                  </div>";
                                }
                              ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control mb-0" id="exampleInputEmail1" name="email" placeholder="Enter email" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <a href="forgot_password.php" class="float-right">Forgot password?</a>
                                    <input type="password" class="form-control mb-0" id="exampleInputPassword1" name="password" placeholder="Password" required>
                                </div>
                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" required>
                                        <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right" name="">Sign in</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="register.php">Sign up</a></span>
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
      <!-- Apexcharts JavaScript -->
      <script src="js/apexcharts.js"></script>
      <!-- lottie JavaScript -->
      <script src="js/lottie.js"></script>
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
