<?php

	class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('usersdata.db');
    }
}
	$db = new MyDB();
	$result = 0;
	function redirect(){
		header('Location:https://www.google.com/search?q=error&oq=error&aqs=chrome..69i57.1440j0j1&sourceid=chrome&ie=UTF-8');
		exit;
	}
	function redirect2(){
		header('Location:https://www.google.com/search?q=error&oq=error&aqs=chrome..69i57.1440j0j1&sourceid=chrome&ie=UTF-8');
		exit;
	}

	if (isset($_POST['submit-reset'])) {
		$password = $_POST['password1'];
		$confirm_password = $_POST['password2'];
		$email = $_GET['email'];
		$token = $_GET['token'];
		if ($password !== $confirm_password) {
			$result = 1;
		}else{
			if(strlen($password)>=8){
				if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password)) {
					if ($result == 0) {
						$hashedpassword = password_hash($password, PASSWORD_BCRYPT);
						$db->query("UPDATE usersdata SET password='$hashedpassword'  WHERE email='$email' and token='$token'");
						$token = 'qadfiahdfnjansdfjSDAFHAIUDFHNJ123456789';
						$token = str_shuffle($token);
						$token = substr($token, 0, 10);
						$db->query("UPDATE usersdata SET token='$token' WHERE email='$email'");
						header('Location:login.php');
					}

				}else{
					$result = 3;
				}

			}else{
				$result = 2;
			}
		}
	}

	elseif(!isset($_GET['email']) || !isset($_GET['token'])) {
		redirect();
	} else {

		$email = $_GET['email'];
		$token = $_GET['token'];

		$usercheck = $db->query("SELECT count(*) as count FROM usersdata WHERE email='$email' AND token='$token'");
		$no_of_users = $usercheck->fetchArray();

		if ($no_of_users['count']>0) {
			
		} else{
			redirect2();
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
                            <h1 class="mb-0">Password Reset</h1>
                            <form class="mt-4" name="PasswordresetForm" action="password_reset.php" method="POST" enctype="multipart/form-data">
                              <?php
                                  if ($result == 1) {
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      All fields are required!!
                                    </div>";
                                  }
                                  elseif($result == 2){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Password must be more than 7 Characters
                                    </div>";
                                  }
                                  elseif($result == 8){
                                    echo "<div class=\"alert alert-danger\" role=\"alert\" >
                                      Password must contain Alphabets and Numerics
                                    </div>";
                                  }
                                ?>
                                
                                <div class="form-group">
                                    <input type="password" class="form-control mb-0" name="password1" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <input type="Password" class="form-control mb-0" name="password2" placeholder="Re-enter Password" required>
                                </div>
                                
                                <div class="d-inline-block">
                                    
                                    <button type="submit" class="btn btn-primary" name="submit-reset">Reset Password</button>
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