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

	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		redirect();
	} else {

		$email = $_GET['email'];
		$token = $_GET['token'];

		$usercheck = $db->query("SELECT count(*) as count FROM usersdata WHERE email='$email' AND token='$token' AND confirmation=0");
		$no_of_users = $usercheck->fetchArray();

		if ($no_of_users['count']>0) {
			$db->query("UPDATE usersdata SET confirmation=1 WHERE email='$email'");
			$result = 1;
			$token = 'qadfiahdfnjansdfjSDAFHAIUDFHNJ123456789';
			$token = str_shuffle($token);
			$token = substr($token, 0, 10);
			$db->query("UPDATE usersdata SET token='$token' WHERE email='$email'");
		} else{
			$result = 2;
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
                    <div class="col-md-9">
                        <div class="sign-in-from bg-white" style="margin-top: 50px;padding-top: 30px; padding-bottom: 70px;">
                            <form class="mt-4" style="text-align: center;">
                              <?php
                                  if ($result == 1) {
                                    echo "<img src=\"images/success.png\" width=\"100%\">
										                <h3>Thanks for confirming your email</h3>
										                <span>Now you can be part of any community without any hurdles.</span>";
		                            }
                                  elseif($result == 2){
                                    echo "<img src=\"images/failed.png\" alt=\"\" width=\"100%\" >
									                   <h3>There is something wrong!!</h3>
									                   <span>Please try again, if possible register again!.</span>";
                                  }
                                ?>
                                <br><br>
                         		<a href="login.php" style="margin-top: 20px;">Whitespot Login </a>
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